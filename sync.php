<?php
require_once('config.php');
require_once('iptables.php');

function debug($message)
{
	global $config;
	if ($config['debug'])
	{
		echo $message . "\n";
	}
}

// Put the current cache into an array so we can compare easily
$cache = array();
if (file_exists($config['cache_location']))
{
	$cache = unserialize(file_get_contents($config['cache_location']));
}

// Make sure hosts exists in configuration
if (!isset($config['hosts']) || !is_array($config['hosts']))
{
	throw new Execption("Hosts configuration not set or not an array");
}

// Loop through hosts
foreach($config['hosts'] as $host => $label)
{
	debug("\n----------");

	// Get the IP of the host
	$ip = gethostbyname($host);
	debug("$host resolved to $ip");
	$resolveFailed = ($ip === $host);
	$add = true;

	// Find the cache object for this
	if (isset($cache[$host]))
	{
		// If it's different, update iptables
		debug("Cache hit");
		$old = $cache[$host];

		if ($old === $ip)
		{
			// IP has not changed. Don't delete, and don't add.
			debug("IP has not changed, continue\n----------");
			continue;
		}
		else
		{
			// Delete old rule
			debug("IP changed, rule to be deleted");
			IPTables::delete($ip, $config['iptables_action'], $config['iptables_chain']);
		}
	}

	// Add new rule as long as resolve was successful
	if (!$resolveFailed)
	{
		debug("Add new rule for $ip");
		IPTables::add($ip, $config['iptables_action'], $config['iptables_chain']);
	}

	debug("Update cache");
	// Update cache
	$cache[$host] = $ip;

	debug("----------");
}

// Write to cache
file_put_contents($config['cache_location'], serialize($cache));
