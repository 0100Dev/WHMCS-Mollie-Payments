<?php

require_once __DIR__ . '/mollie/mollie.php';

function molliesofort_devapp_config() {
	$config = mollie_config();

	$config = array_merge($config, array(
		'FriendlyName' => array(
			'Type' => 'System',
			'Value'=> 'Mollie Sofort Banking'
		)
	));

	return $config;
}

function molliesofort_devapp_link($params) {
	return mollie_link($params, Mollie_API_Object_Method::SOFORT);
}
