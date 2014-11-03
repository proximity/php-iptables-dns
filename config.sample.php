<?php
$config = array(
	'enable_cache_read'		=> true,
	'enable_cache_write'	=> true,
	'debug'					=> false,
	'iptables_chain'		=> 'INPUT',
	'iptables_action'		=> 'ACCEPT',
	'cache_location'		=> dirname(__FILE__) . '/.cache',
	'hosts'					=> array(
		'hostname' => 'Friendly name',
	)
);
