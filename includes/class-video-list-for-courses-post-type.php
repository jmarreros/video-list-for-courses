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

	private static $found_items = 0;
	private static $current = null;

	private $id = 0;
	private $title = 'Default title';
	private $content = '';

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

	public static function count() {
		return self::$found_items;
	}

	public static function find( $args = '' ) {
		$defaults = array(
			'post_status' => 'any',
			'posts_per_page' => -1,
			'offset' => 0,
			'orderby' => 'ID',
			'order' => 'ASC',
		);

		$args = wp_parse_args( $args, $defaults );

		$args['post_type'] = self::post_type;

		$q = new WP_Query();
		$posts = $q->query( $args );

		self::$found_items = $q->found_posts;

		$objs = array();

		foreach ( (array) $posts as $post ) {
			$objs[] = new self( $post );
		}

		return $objs;
	}

	private function __construct ( $id ){
		if ( ! empty($id) ){
			$post = get_post( $id );

			if ( $post && self::post_type == get_post_type( $post ) ){
				$this->id = $post->ID;
				$this->title = $post->post_title;
				$this->content = $post->post_content;
			}

		}
	}


	public function id() {
		return $this->id;
	}

	
	public function title() {
		return $this->title;
	}

	public function content() {
		return $this->content;
	}

	public function initial() {
		return empty( $this->id );
	}

	public static function get_current() {
		return self::$current;
	}

	public static function get_instance( $id = 0 ) {
		return self::$current = new self( $id );
	}


}