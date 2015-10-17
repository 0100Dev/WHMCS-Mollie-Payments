<?php

require_once 'mollie/mollie.php';

function molliemistercash_config() {
	$config = mollie_config();

	$config = array_merge($config, array(
		'FriendlyName' => array(
			'Type' => 'System',
			'Value'=> 'Mollie Mistercash'
		)
	));

	return $config;
}

function molliemistercash_link($params) {
	return mollie_link($params, Mollie_API_Object_Method::MISTERCASH);
}
