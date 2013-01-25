<?php
require_once(sprintf("%s/../../../wp-load.php", dirname(__FILE__)));
require_once(sprintf("%s/wp_bullhorn.php", dirname(__FILE__)));

if(class_exists("WP_Bullhorn"))
{
	$wp_bullhorn_plugin = new WP_Bullhorn();
	$wp_bullhorn_plugin->sync();
}