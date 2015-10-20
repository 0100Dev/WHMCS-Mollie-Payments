<?php
/**
 *
 *	Setting requirements and includes
 *
 */
require_once __DIR__ . '/../../../init.php';
require_once __DIR__ . '/vendor/Mollie/src/Mollie/API/Autoloader.php';

$whmcs->load_function('gateway');
$whmcs->load_function('invoice');

/**
 *
 *	Check parameters
 *
 */
if(isset($_POST['id'])) {

    // Get transaction
    $transactionQuery = select_query('gateway_mollie', '', array('paymentid' => $_POST['id']), null, null, 1);

    if (mysql_num_rows($transactionQuery) != 1) {
        logTransaction('mollieunknown', $_POST, 'Callback - Failure 2 (Transaction not found)');

        header('HTTP/1.1 500 Transaction not found');
        exit();
    }

    $transaction = mysql_fetch_assoc($transactionQuery);

    $_GATEWAY = getGatewayVariables('mollie' . $transaction['method']);

    if ($transaction['status'] != 'open') {
        logTransaction($_GATEWAY['paymentmethod'], array_merge($transaction, $_POST), 'Callback - Failure 3 (Transaction not open)');

        header('HTTP/1.1 500 Transaction not open');
        exit();
    }

    // Get user and transaction currencies
    $userCurrency = getCurrency($transaction['userid']);
    $transactionCurrency = select_query('tblcurrencies', '', array('id' => $transaction['currencyid']));
    $transactionCurrency = mysql_fetch_assoc($transactionCurrency);

    // Check payment
    $mollie = new Mollie_API_Client;
    $mollie->setApiKey($_GATEWAY['key']);

    $payment  = $mollie->payments->get($_POST['id']);

    if($payment->isPaid()) {

        // Add conversion, when there is need to. WHMCS only supports currencies per user. WHY?!
        if ($transactionCurrency['id'] != $userCurrency['id']) {
            $transaction['amount'] = convertCurrency($transaction['amount'], $transaction['currencyid'], $userCurrency['id']);
        }

        // Check invoice
        $invoiceid = checkCbInvoiceID($transaction['invoiceid'], $_GATEWAY['paymentmethod']);

        checkCbTransID($transaction['paymentid']);

        // Add invoice
        addInvoicePayment($invoiceid, $transaction['paymentid'], $transaction['amount'], '', $_GATEWAY['paymentmethod']);

        update_query('gateway_mollie', array('status' => 'paid', 'updated' => date('Y-m-d H:i:s', time())), array('id' => $transaction['id']));

        logTransaction($_GATEWAY['paymentmethod'], array_merge($transaction, $_POST), 'Callback - Successful (Paid)');

        header('HTTP/1.1 200 OK');
        exit();
    } else if ($payment->isOpen() == FALSE) {
        update_query('gateway_mollie', array('status' => 'closed', 'updated' => date('Y-m-d H:i:s', time())), array('id' => $transaction['id']));

        logTransaction($_GATEWAY['paymentmethod'], array_merge($transaction, $_POST), 'Callback - Successful (Closed)');

        header('HTTP/1.1 200 OK');
        exit();
    } else {
        logTransaction($_GATEWAY['paymentmethod'], array_merge($transaction, $_POST), 'Callback - Failure 1 (Payment not open or paid)');

        header('HTTP/1.1 500 Payment not open or paid');
        exit();
    }
}else{
    logTransaction('mollieunknown', $_POST, 'Callback - Failure 0 (Arg mismatch)');

    header('HTTP/1.1 500 Arg mismatch');
    exit();
}
