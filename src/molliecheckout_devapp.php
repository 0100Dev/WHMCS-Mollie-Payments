<?php

require_once __DIR__ . '/mollie/mollie.php';

function molliecheckout_devapp_config()
{
    $config = mollie_config();

    $config = array_merge($config, array(
        'FriendlyName' => array(
            'Type' => 'System',
            'Value' => 'Mollie Checkout'
        )
    ));

    return $config;
}

function molliecheckout_devapp_link($params)
{
    return mollie_link($params, null);
}

