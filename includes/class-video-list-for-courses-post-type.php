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
	const taxonomy = 'vlfc_groups';

	private static $found_items = 0;
	private static $current = null;

	private $id;
	private $title;
	private $content;
	private $thumbnail_url;
	private $order;
	private $description;
	private $showlist;


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
				$this->set_description( $post->post_excerpt );
				$this->set_thumbnail( get_post_meta($id, VLFC_THUMBNAIL, true) );
				$this->set_order( get_post_meta($id, VLFC_ORDER, true) );
				$this->set_showlist( get_post_meta($id, VLFC_SHOWLIST, true) );
			}
		}
		else {
			$this->set_id( 0 );
			$this->set_title('');
			$this->set_content('');
			$this->set_thumbnail('');
			$this->set_order(1);
			$this->set_description('');
			$this->set_showlist(false);
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

	public function thumbnail(){
		return $this->thumbnail_url;
	}

	public function order(){
		return $this->order;
	}

	public function description(){
		return $this->description;
	}

	public function showlist(){
		return $this->showlist;
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

	public function set_thumbnail( $url ){
		$this->thumbnail_url = $url;
	}

	public function set_order($order){
		$this->order = intval($order);
	}

	public function set_description($description){
		$this->description = $description;
	}

	public function set_showlist($val){
		$this->showlist = filter_var($val, FILTER_VALIDATE_BOOLEAN );
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
		$id_course = 0;
		$args = [
			'ID' => $this->id(),
			'post_title' => $this->title(),
			'post_content' => $this->content(),
			'post_excerpt' => $this->description(),
			'post_status' => 'publish',
			'post_type' => self::post_type
		];

		// new course
		if ( $this->id() == 0 ){
			$id_course =  wp_insert_post( $args , true );
		} else { // edit a course
			$id_course = wp_update_post( $args , true );
		}

		if ( $id_course ) {
			$this->set_id($id_course);
			$this->save_thumbnail();
			$this->save_order();
			$this->save_showlist();
		}

		return $id_course;
	}

	// save thumbnail
	public function save_thumbnail(){
		if ( $this->thumbnail_url ){
			return update_post_meta($this->id(), VLFC_THUMBNAIL, $this->thumbnail_url);
		}
	}

	// save order
	public function save_order(){
		if ( $this->order ){
			return update_post_meta($this->id(), VLFC_ORDER, $this->order);
		}
	}

	// save showlist
	public function save_showlist(){
		return update_post_meta($this->id(), VLFC_SHOWLIST, $this->showlist);
	}


	// Delete a course
	public static function delete_course( $course_id ) {
		return wp_delete_post( $course_id, true );
	}

	// List all courses, return associative array
	public static function list_courses(){
		$courses = array();
		$i = 0;

		$args = array(
			'post_type' => 'vlfc_video_courses',
			'orderby'   => 'meta_value_num',
			'meta_key' => VLFC_ORDER,
			'meta_query' => [
                'key' => VLFC_SHOWLIST,
                'value' => 1,
                'compare' => '=',
                'type' => 'NUMERIC'
            ]
		);

		$query = new WP_Query( $args );

		while ($query->have_posts()){
			$query->the_post();
			$id = get_the_ID();

			// Fill var $courses to return
			$courses[$i]['id'] = $id;
			$courses[$i]['description'] = get_the_excerpt();
			$courses[$i]['image'] = get_post_meta($id, VLFC_THUMBNAIL, true );
			$i++;
		}

		wp_reset_query();

		return $courses;
	}

}


// public static function register_post_type() {
	// 	register_post_type( self::post_type, array(
	// 		'labels' => array(
	// 			'name' => __( 'Video List Courses cpt', 'video-list-for-courses' ),
	// 			'singular_name' => __( 'Video Course cpt', 'video-list-for-courses' ),
	// 		),
	// 		'rewrite' => false,
	// 		'query_var' => false,
	// 	) );

	// 	add_post_type_support( self::post_type, 'thumbnail' );
	// }

	// public static function register_taxonomy(){
	// 	register_taxonomy( self::taxonomy, 'vlfc' ,array(
	// 		'hierarchical' => false,
	// 		'labels' => array(
	// 			'name' => __( 'Groups', 'video-list-for-courses' ),
	// 			'singular_name' => __( 'Group', 'video-list-for-courses' ),
	// 		),
	// 		'show_ui' => true,
	// 		'query_var' => true,
	// 		'rewrite' => array( 'slug' => 'group' ),
	// 	  ));
	// }