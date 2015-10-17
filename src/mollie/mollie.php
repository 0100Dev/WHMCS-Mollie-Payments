<?php

require_once 'vendor/Mollie/src/Mollie/API/Autoloader.php';

function mollie_config() {
    return array(
        'key' => array(
            'FriendlyName' => 'API key',
            'Type' => 'text',
            'Size' => '35',
            'Description' => 'Your channel\'s API key.'
        )
    );
}

function mollie_link($params, $method = Mollie_API_Object_Method::IDEAL) {
    global $whmcs;

    /**
     *
     *	Setting requirements and includes
     *
     */
    if(substr($params['returnurl'], 0, 1) == '/')
        $params['returnurl'] = $params['systemurl'].$params['returnurl'];

    if (empty($params['language']))
        $params['language'] = ((isset($_SESSION['language'])) ? $_SESSION['language'] : $whmcs->get_config('Language'));

    if (empty($params['language']))
        $params['language'] = 'english';

    if (!file_exists(__DIR__ . '/lang/' . $params['language'] . '.php'))
        $params['language'] = 'english';

    /* @var array $_GATEWAYLANG */
    require __DIR__ . '/lang/' . $params['language'] . '.php';

    $tableCheckQuery = full_query('SHOW TABLES LIKE \'gateway_mollie\'');

    if (mysql_num_rows($tableCheckQuery) != 1) {
        full_query('CREATE TABLE IF NOT EXISTS `gateway_mollie` (`id` int(11) NOT NULL AUTO_INCREMENT, `paymentid` varchar(15), `amount` double NOT NULL, `currencyid` int(11) NOT NULL, `ip` varchar(50) NOT NULL, `userid` int(11) NOT NULL, `invoiceid` int(11) NOT NULL, `status` ENUM(\'open\',\'paid\',\'closed\') NOT NULL DEFAULT \'open\', `method` VARCHAR(25) NOT NULL,  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, `updated` timestamp NULL DEFAULT NULL, PRIMARY KEY (`id`), UNIQUE KEY `paymentid` (`paymentid`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');
    }

    $mollie = new Mollie_API_Client;
    $mollie->setApiKey($params['key']);

    /**
     *
     *	Check if good state to open transaction.
     *
     */
    if (isset($_GET['check_payment']) && ctype_digit($_GET['check_payment'])) {
        $transactionQuery = select_query('gateway_mollie', '', array('id' => $_GET['check_payment']), null, null, 1);

        if (mysql_num_rows($transactionQuery) != 1) {
            return '<p>' . $_GATEWAYLANG['errorTransactionNotFound'] . '</p>';
        }

        $transaction = mysql_fetch_assoc($transactionQuery);

        if ($transaction['status'] == 'paid') {
            header('location: ' . $params['returnurl'] . '&paymentsuccess=true');
            exit();
        } else if ($transaction['status'] == 'closed') {
            header('location: ' . $params['returnurl'] . '&paymentfailed=true');
            exit();
        } else {
            return '<br/><img src="' . $params['systemurl'] . '/modules/gateways/mollie/ajax_loader.gif" /><br/>' . $_GATEWAYLANG['checkPayment'] . ' <script> window.onload = function(){ setTimeout("location.reload(true);", 2000); } </script>';
        }
    } else {
        if (isset($_POST['start']) || (isset($_GET['a']) && $_GET['a'] == 'complete') || (isset($_GET['action']) && ($_GET['action'] == 'addfunds' || $_GET['action'] == 'masspay') && isset($_POST['paymentmethod']) && $_POST['paymentmethod'] == 'mollie' . $method)) {

            $transactionCurrency = select_query('tblcurrencies', '', array('code' => $params['currency']), null, null, 1);
            $transactionCurrency = mysql_fetch_assoc($transactionCurrency);

            $transactionId = insert_query('gateway_mollie', array(
                'amount' => $params['amount'],
                'currencyid' => $transactionCurrency['id'],
                'ip' => $_SERVER['REMOTE_ADDR'],
                'userid' => $params['clientdetails']['userid'],
                'invoiceid' => $params['invoiceid'],
                'method' => $method
            ));

            $payment = $mollie->payments->create(array(
                'amount' => $params['amount'],
                'method' => $method,
                'description' => $params['description'],
                'redirectUrl' => $params['returnurl'] . '&check_payment=' . $transactionId,
                'webhookUrl' => $params['systemurl'] . '/modules/gateways/mollie/callback.php',
                'metadata' => array(
                    'invoice_id' => $params['invoiceid'],
                ),
                'issuer' => ((isset($_POST['issuer']) && !empty($_POST['issuer'])) ? $_POST['issuer'] : NULL)
            ));

            update_query('gateway_mollie', array('paymentid' => $payment->id), array('id' => $transactionId));

            header('Location: ' . $payment->getPaymentUrl());
            exit();
        } else {
            $return = '<form action="" method="POST">';

            if ($method == Mollie_API_Object_Method::IDEAL) {
                $issuers = $mollie->issuers->all();

                $return .= '<label for="issuer">' . $_GATEWAYLANG['selectBank'] . ':</label> ';

                $return .= '<select name="issuer">';
                foreach ($issuers as $issuer) {
                    if ($issuer->method == Mollie_API_Object_Method::IDEAL) {
                        $return .= '<option value=' . htmlspecialchars($issuer->id) . '>' . htmlspecialchars($issuer->name) . '</option>';
                    }
                }
                $return .= '</select>';
            }

            $return .= '<input type="submit" name="start" value="' . $_GATEWAYLANG['payWith' . ucfirst($method)] . '" /></form>';

            return $return;
        }
    }
}