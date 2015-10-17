<?php

require_once 'mollie/mollie.php';

function mollieideal_config() {
	$config = mollie_config();

	$config = array_merge($config, array(
		'FriendlyName' => array(
			'Type' => 'System',
			'Value'=> 'Mollie iDeal'
		)
	));

	return $config;
}

function mollieideal_link($params) {
	return mollie_link($params, Mollie_API_Object_Method::IDEAL);
}
