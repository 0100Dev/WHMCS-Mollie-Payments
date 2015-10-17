<?php

require_once 'mollie/mollie.php';

function molliebitcoin_config() {
	$config = mollie_config();

	$config = array_merge($config, array(
		'FriendlyName' => array(
			'Type' => 'System',
			'Value'=> 'Mollie Bitcoin'
		)
	));

	return $config;
}

function molliebitcoin_link($params) {
	return mollie_link($params, Mollie_API_Object_Method::BITCOIN);
}
