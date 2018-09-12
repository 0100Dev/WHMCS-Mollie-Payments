<?php

require_once __DIR__ . '/mollie/mollie.php';

function molliebelfius_devapp_config()
{
    $config = mollie_config();

    $config = array_merge($config, array(
        'FriendlyName' => array(
            'Type' => 'System',
            'Value' => 'Mollie Belfius'
        )
    ));

    return $config;
}

function molliebelfius_devapp_link($params)
{
    return mollie_link($params, \Mollie\Api\Types\PaymentMethod::BELFIUS);
}
