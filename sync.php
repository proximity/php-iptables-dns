<?php
require_once('config.php');

// Put the current cache into an array so we can compare easily
$cache = array();
if (file_exists($config['cache_location']))
{
	$cache = json_decode(file_get_contents($config['cache_location']));
}

// Make sure hosts exists in configuration
if (!isset($config['hosts']) || !is_array($config['hosts']))
{
	throw new Execption("Hosts configuration not set or not an array");
}

// Loop through hosts
foreach($config['hosts'] as $host => $label)
{
	// Get the IP of the host
	$ip = gethostbyname($host);
	$resolveFailed = ($ip === $host);
	$add = true;

	// Find the cache object for this
	if (isset($cache[$host]))
	{
		// If it's different, update iptables
		$old = $cache[$host];

		if ($old === $ip)
		{
			// IP has not changed. Don't delete, and don't add.
			$add = false;
		}
		else
		{
			// Delete old rule
			IPTables::delete($ip);
		}
	}

	// Add new rule as long as resolve was successful
	if (!$resolveFailed && $add)
	{
		IPTables::add($ip);
	}

	// Update cache
	$cache[$host] = $ip;
}

// Write to cache
file_put_contents($config['cache_location'], json_encode($cache));
