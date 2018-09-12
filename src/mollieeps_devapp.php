<?php

require_once __DIR__ . '/mollie/mollie.php';

function mollieeps_devapp_config()
{
    $config = mollie_config();

    $config = array_merge($config, array(
        'FriendlyName' => array(
            'Type' => 'System',
            'Value' => 'Mollie EPS'
        )
    ));

    return $config;
}

function mollieeps_devapp_link($params)
{
    return mollie_link($params, \Mollie\Api\Types\PaymentMethod::EPS);
}
