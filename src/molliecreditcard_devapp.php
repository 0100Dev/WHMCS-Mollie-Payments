<?php

require_once __DIR__ . '/mollie/mollie.php';

function molliecreditcard_devapp_config()
{
    $config = mollie_config();

    $config = array_merge($config, array(
        'FriendlyName' => array(
            'Type' => 'System',
            'Value' => 'Mollie Creditcard'
        )
    ));

    return $config;
}

function molliecreditcard_devapp_link($params)
{
    return mollie_link($params, \Mollie\Api\Types\PaymentMethod::CREDITCARD);
}
