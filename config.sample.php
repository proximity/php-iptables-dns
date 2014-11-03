<?php
$config = array(
	'debug'				=> false,
	'iptables_chain'	=> 'INPUT',
	'iptables_action'	=> 'ACCEPT',
	'cache_location'	=> dirname(__FILE__) . '/.cache',
	'hosts'				=> array(
		'hostname' => 'Friendly name',
	)
);
