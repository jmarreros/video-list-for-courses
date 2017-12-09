<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://decodecms.com
 * @since             1.0.0
 * @package           Video_List_For_Courses
 *
 * @wordpress-plugin
 * Plugin Name:       Video List for Courses
 * Plugin URI:        https://decodecms.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Jhon Marreros Guzmán
 * Author URI:        https://decodecms.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       video-list-for-courses
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently pligin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-video-list-for-courses-activator.php
 */
function activate_video_list_for_courses() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-video-list-for-courses-activator.php';
	Video_List_For_Courses_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-video-list-for-courses-deactivator.php
 */
function deactivate_video_list_for_courses() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-video-list-for-courses-deactivator.php';
	Video_List_For_Courses_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_video_list_for_courses' );
register_deactivation_hook( __FILE__, 'deactivate_video_list_for_courses' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-video-list-for-courses.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_video_list_for_courses() {

	$plugin = new Video_List_For_Courses();
	$plugin->run();

}
run_video_list_for_courses();
