<?php
/*
Plugin Name: WP Bullhorn
Plugin URI: http://fyaconiello.github.com/wp-bullhorn/
Description: Bullhorn Integration Plugin for Wordpress
Version: 1.0
Author: Francis Yaconiello
Author URI: http://www.yaconiello.com
License: GPL2
*/
/*
Copyright 2012  Francis Yaconiello  (email : francis@yaconiello.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


if(!class_exists('WP_Bullhorn'))
{
    class WP_Bullhorn
    {
        const OPTIONS_GROUP = "wpbullhorn-group";

        /**
         * Construct the plugin object
         */
        public function __construct()
        {
            // register actions
            add_action('init', array(&$this, 'init'));
            add_action('admin_init', array(&$this, 'admin_init'));
            add_action('admin_menu', array(&$this, 'add_menu'));
            add_action('daily_bullhorn_sync', array('WP_Bullhorn', 'sync'));

            // Settings link on the plugin page
            $plugin = plugin_basename(__FILE__); 
            add_filter("plugin_action_links_$plugin", array('WP_Bullhorn', 'plugin_settings_link'));

            // Import JobOrder class, and register an instance of it as a global
            global $job_order;
            require_once(sprintf("%s/includes/JobOrder.php", dirname(__FILE__)));
            $job_order = new JobOrder();
        } // END public function __construct

        /**
         * hook into WP's init action hook
         */
        public function init()
        {
            // Do Something
        } // END public static function activate

        /**
         * hook into WP's admin_init action hook
         */
        public function admin_init()
        {
            // Set up the settings for this plugin
            $this->init_settings();
        } // END public static function activate

        /**
         * add a menu
         */		
        public function add_menu()
        {
            add_options_page('WP Bullhorn Settings', 'WP Bullhorn', 'manage_options', 'wp_bullhorn', array(&$this, 'plugin_settings_page'));
        } // END public function add_menu()

        /**
         * Initialize some custom settings
         */		
        public function init_settings()
        {
            // register the settings for this plugin
            register_setting(self::OPTIONS_GROUP, 'bh_username');
            register_setting(self::OPTIONS_GROUP, 'bh_password');
            register_setting(self::OPTIONS_GROUP, 'bh_api_key');
        } // END public function init_settings()

        /**
         * Menu Callback
         */		
        public function plugin_settings_page()
        {
            if(!current_user_can('manage_options'))
            {
                wp_die(__('You do not have sufficient permissions to access this page.'));
            }

            // Render the settings template
            include(sprintf("%s/templates/settings.php", dirname(__FILE__)));
        } // END public function plugin_settings_page()

        /**
         * Add the settings link to the plugins page
         */
        public static function plugin_settings_link($links)
        { 
            $settings_link = '<a href="options-general.php?page=wp_bullhorn">Settings</a>'; 
            array_unshift($links, $settings_link); 
            return $links; 
        }
        
        /**
         * Create a function that syncs all of the API data
         */
        public static function sync()
        {
            // Include the JobOrder Post class
            require_once(sprintf("%s/includes/JobOrder.php", dirname(__FILE__)));
            // Instantiate a JobOrder class instance and sync
            $job_order = new JobOrder();
            $job_order->sync();
        }
        
        /**
         * Activate the plugin
         */
        public static function activate()
        {
            // Register an event if not already registered            
            if(!wp_next_scheduled('daily_bullhorn_sync'))
            {
                // Register an action for this event 
                add_action('daily_bullhorn_sync', array('WP_Bullhorn', 'sync'));
                // Schedule this event 
                wp_schedule_event(time(), 'daily', 'daily_bullhorn_sync');
	        } // END if(!wp_next_scheduled('daily_bullhorn_sync'))
        } // END public static function activate

        /**
         * Deactivate the plugin
         */		
        public static function deactivate()
        {
            // Check to see if an event is scheduled
            if(($timestamp = wp_next_scheduled('daily_bullhorn_sync')) != FALSE)
            {
                // Unschedule the event
                wp_unschedule_event($timestamp, 'daily_bullhorn_sync');
            } // END if(($timestamp = wp_next_scheduled('daily_bullhorn_sync')) != FALSE)
        } // END public static function deactivate
    } // END class WP_Bullhorn
} // END if(!class_exists('WP_Bullhorn'))

if(class_exists('WP_Bullhorn'))
{
    // Installation and uninstallation hooks
    register_activation_hook(__FILE__, array('WP_Bullhorn', 'activate'));
    register_deactivation_hook(__FILE__, array('WP_Bullhorn', 'deactivate'));

    // instantiate the plugin class
    $wp_bullhorn_plugin = new WP_Bullhorn();
} // END if(class_exists('WP_Bullhorn'))