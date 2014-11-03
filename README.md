
# php-iptables-dns

We have an internal app which we need to limit access to with iptables.
Unfortunately we all have dynamic IP addresses, so we needed something
to automatically update our firewall when our IP addresses changed so
we could still access the app.

Here it is.

Some simple configuration, and you can store a list of hostnames to
keep in sync with an iptables chain.

Needs shell_exec to run.
