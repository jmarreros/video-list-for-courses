<?php
/**
 * Custom post type class
 *
 * @link       https://decodecms.com
 * @since      1.0.0
 *
 * @package    Video_List_For_Courses
 * @subpackage Video_List_For_Courses/includes
 */

/**
 * Core data for video list of courses
 *
 * This class defines all code necessary to run the custom post type video_list_for_courses
 *
 * @since      1.0.0
 * @package    Video_List_For_Courses
 * @subpackage Video_List_For_Courses/includes
 * @author     Jhon Marreros Guzmán <admin@decodecms.com>
*/
class VLFC_CPT{
	
	const post_type = 'vlfc_video_courses';

	public static function register_post_type() {
		register_post_type( self::post_type, array(
			'labels' => array(
				'name' => __( 'Video List Courses cpt', 'video-list-for-courses' ),
				'singular_name' => __( 'Video Course cpt', 'video-list-for-courses' ),
			),
			'rewrite' => false,
			'query_var' => false,
		) );
	}

	private function __construct ( $post = null){
		$post = get_post( $post );

		if ( $post && self::post_type == get_post_type( $post ) ) {

		}
	}

}