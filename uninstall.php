<?php // exit if uninstall constant is not defined
if (!defined('WP_UNINSTALL_PLUGIN')) exit;

if (get_option('adsterra_option_check', true)) {
	delete_option('adsterra_option_apikey');
	delete_option('adsterra_option_check');
}