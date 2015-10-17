<?php

require_once 'mollie/mollie.php';

function molliepaypal_config() {
	$config = mollie_config();

	$config = array_merge($config, array(
		'FriendlyName' => array(
			'Type' => 'System',
			'Value'=> 'Mollie PayPal'
		)
	));

	return $config;
}

function molliepaypal_link($params) {
	return mollie_link($params, Mollie_API_Object_Method::PAYPAL);
}
