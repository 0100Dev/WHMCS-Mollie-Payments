<?php

require_once __DIR__ . '/mollie/mollie.php';

function mollieprzelewy24_devapp_config()
{
    $config = mollie_config();

    $config = array_merge($config, array(
        'FriendlyName' => array(
            'Type' => 'System',
            'Value' => 'Mollie Przelewy24'
        )
    ));

    return $config;
}

function mollieprzelewy24_devapp_link($params)
{
    return mollie_link($params, \Mollie\Api\Types\PaymentMethod::PRZELEWY24);
}
