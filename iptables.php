<?php

class IPTables {
	static function add($ip, $action = 'ACCEPT', $chain = 'INPUT', $appendPrepend = 'APPEND')
	{
		$ipEscaped = escapeshellarg($ip);
		$appendPrependSwitch = ($appendPrepend === 'APPEND') ? '-A' : '-I';
		$cmd = "iptables $appendPrependSwitch $chain -s $ipEscaped -j $action";
		debug($cmd);
		shell_exec($cmd);
	}

	static function delete($ip, $action = 'ACCEPT', $chain = 'INPUT')
	{
		$ipEscaped = escapeshellarg($ip);
		$cmd = "iptables -D $chain -s $ipEscaped -j $action";
		debug($cmd);
		shell_exec($cmd);
	}
}
