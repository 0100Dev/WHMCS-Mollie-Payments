<?php

require_once 'mollie/mollie.php';

function molliesofort_config() {
	$config = mollie_config();

	$config = array_merge($config, array(
		'FriendlyName' => array(
			'Type' => 'System',
			'Value'=> 'Mollie Sofort Banking'
		)
	));

	return $config;
}

function molliesofort_link($params) {
	return mollie_link($params, Mollie_API_Object_Method::SOFORT);
}
