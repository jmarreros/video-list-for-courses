<?php
/**
 *
 * @link              https://decodecms.com
 * @since             1.0.0
 * @package           Video_List_For_Courses
 *
 * @wordpress-plugin
 * Plugin Name:       Video List for Courses
 * Plugin URI:        https://decodecms.com
 * Description:       Creates shorcodes, shows a list links  of videos.
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
 * Currently plugin version an plugin name.
*/
define( 'VLFC_VERSION', '1.0.0' );
define( 'VLFC_NAME', 'video-list-for-courses' );


/**
 * The code that runs during plugin activation and desactivation
 */
function activate_video_list_for_courses() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-video-list-for-courses-activator.php';
	Video_List_For_Courses_Activator::activate();
}

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

function run_video_list_for_courses() {

	$plugin = new Video_List_For_Courses();
	$plugin->run();

}
run_video_list_for_courses();
