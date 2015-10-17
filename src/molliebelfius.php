<?php

require_once 'mollie/mollie.php';

function molliebelfius_config() {
	$config = mollie_config();

	$config = array_merge($config, array(
		'FriendlyName' => array(
			'Type' => 'System',
			'Value'=> 'Mollie Belfius'
		)
	));

	return $config;
}

function molliebelfius_link($params) {
	return mollie_link($params, Mollie_API_Object_Method::BELFIUS);
}
