<?php

require_once __DIR__ . '/mollie/mollie.php';

function molliedirectdebit_config() {
	$config = mollie_config();

	$config = array_merge($config, array(
		'FriendlyName' => array(
			'Type' => 'System',
			'Value'=> 'Mollie Direct Debit'
		)
	));

	return $config;
}

function molliedirectdebit_link($params) {
	return mollie_link($params, Mollie_API_Object_Method::DIRECTDEBIT);
}
