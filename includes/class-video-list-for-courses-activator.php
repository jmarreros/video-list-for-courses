<?php

/**
 * Fired during plugin activation
 *
 * @link       https://decodecms.com
 * @since      1.0.0
 *
 * @package    Video_List_For_Courses
 * @subpackage Video_List_For_Courses/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Video_List_For_Courses
 * @subpackage Video_List_For_Courses/includes
 * @author     Jhon Marreros Guzmán <admin@decodecms.com>
 */
class VLFC_Video_List_For_Courses_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		// delete_option('vlfc_options');

		$vlfc_options = get_option(VLFC_OPTIONS);

		if ( ! $vlfc_options ){

			 	$options = [
			 				'load_css'		=> 'on',
			 				'link_youtube' 	=> 'on'
		 			];

				update_option( VLFC_OPTIONS, $options );
		}

	}

}
