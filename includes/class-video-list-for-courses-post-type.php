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

	private $id;
	private $title;
	private $content;

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
			$post = get_post( $id ); // get from db

			if ( $post && self::post_type == get_post_type( $post ) ){
				$this->set_id( $post->ID );
				$this->set_title( $post->post_title );
				$this->set_content( $post->post_content );
			}
		}
		else {
			$this->set_id( 0 );
			$this->set_title( '' );
			$this->set_content( '' );
		}
	}

	// return values
	public function id() {
		return $this->id;
	}
	
	public function title() {
		return $this->title;
	}

	public function content() {
		return $this->content;
	}

	// set values
	public function set_id( $id ){
		$this->id = $id;
	}

	public function set_title( $title ){
		if ( '' === $title ) {
			$title = __( 'Untitled', 'video-list-for-courses' );
		}
		$this->title = $title;
	}

	public function set_content( $content ){
		$this->content = $content;
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

	// for insert, update, delete, duplicate

	public function save_course(){
		$args = [
			'ID' => $this->id(),
			'post_title' => $this->title(),
			'post_content' => $this->content(),
			'post_status' => 'publish',
			'post_type' => self::post_type
		];

		// new course
		if ( $this->id() == 0 ){
			return wp_insert_post( $args , true );
		}

		// edit a course
		return wp_update_post( $args , true );
	}

	public static function delete_course( $course_id ) {
		return wp_delete_post( $course_id, true );
	}

}