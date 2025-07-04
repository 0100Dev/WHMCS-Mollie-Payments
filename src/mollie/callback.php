<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use Mollie\Api\MollieApiClient;

require_once __DIR__ . '/../../../init.php';
require_once __DIR__ . '/vendor/autoload.php';

$whmcs->load_function('gateway');
$whmcs->load_function('invoice');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['id'])) {
    logTransaction('mollieunknown', $_POST, 'Callback - Failure 0 (Arg mismatch)');
    http_response_code(500);
    exit('Arg mismatch');
}

// Find transaction by Mollie payment ID
$transaction = Capsule::table('gateway_mollie')
    ->where('paymentid', $_POST['id'])
    ->first();

if (!$transaction) {
    logTransaction('mollieunknown', $_POST, 'Callback - Failure 2 (Transaction not found)');
    http_response_code(500);
    exit('Transaction not found');
}

$transaction = (array) $transaction;
$method = $transaction['method'] ?: 'checkout';

// Load gateway configuration
$_GATEWAY = getGatewayVariables('mollie' . $method . '_devapp');

if ($transaction['status'] !== 'open') {
    logTransaction($_GATEWAY['paymentmethod'], array_merge($transaction, $_POST), 'Callback - Failure 3 (Transaction not open)');
    http_response_code(500);
    exit('Transaction not open');
}

// Load currencies
$userCurrency = getCurrency($transaction['userid']);
$transactionCurrency = Capsule::table('tblcurrencies')
    ->where('id', $transaction['currencyid'])
    ->first();

$transactionCurrency = (array) $transactionCurrency;

// Init Mollie
$mollie = new MollieApiClient();
$mollie->setApiKey($_GATEWAY['key']);

try {
    $payment = $mollie->payments->get($_POST['id']);
} catch (Exception $e) {
    logTransaction($_GATEWAY['paymentmethod'], $_POST, 'Callback - Failure 4 (API Error): ' . $e->getMessage());
    http_response_code(500);
    exit('Mollie API error');
}

// Handle payment status
if ($payment->isPaid()) {
    // Currency conversion if needed
    if ($transactionCurrency['id'] != $userCurrency['id']) {
        $transaction['amount'] = convertCurrency($transaction['amount'], $transaction['currencyid'], $userCurrency['id']);
    }

    $invoiceid = checkCbInvoiceID($transaction['invoiceid'], $_GATEWAY['paymentmethod']);
    checkCbTransID($transaction['paymentid']);
    addInvoicePayment($invoiceid, $transaction['paymentid'], $transaction['amount'], '', $_GATEWAY['paymentmethod']);

    Capsule::table('gateway_mollie')
        ->where('id', $transaction['id'])
        ->update(['status' => 'paid', 'updated' => date('Y-m-d H:i:s')]);

    logTransaction($_GATEWAY['paymentmethod'], array_merge($transaction, $_POST), 'Callback - Successful (Paid)');
    http_response_code(200);
    exit('OK');

} elseif (!$payment->isOpen()) {
    Capsule::table('gateway_mollie')
        ->where('id', $transaction['id'])
        ->update(['status' => 'closed', 'updated' => date('Y-m-d H:i:s')]);

    logTransaction($_GATEWAY['paymentmethod'], array_merge($transaction, $_POST), 'Callback - Successful (Closed)');
    http_response_code(200);
    exit('Closed');

} else {
    logTransaction($_GATEWAY['paymentmethod'], array_merge($transaction, $_POST), 'Callback - Failure 1 (Payment not open or paid)');
    http_response_code(500);
    exit('Payment not open or paid');
}

