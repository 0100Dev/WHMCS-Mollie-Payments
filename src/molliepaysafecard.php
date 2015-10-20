<?php

require_once __DIR__ . '/mollie/mollie.php';

function molliepaysafecard_config() {
	$config = mollie_config();

	$config = array_merge($config, array(
		'FriendlyName' => array(
			'Type' => 'System',
			'Value'=> 'Mollie Paysafecard'
		)
	));

	return $config;
}

function molliepaysafecard_link($params) {
	return mollie_link($params, Mollie_API_Object_Method::PAYSAFECARD);
}
