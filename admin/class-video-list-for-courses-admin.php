<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://decodecms.com
 * @since      1.0.0
 *
 * @package    Video_List_For_Courses
 * @subpackage Video_List_For_Courses/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and hooks to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Video_List_For_Courses
 * @subpackage Video_List_For_Courses/admin
 * @author     Jhon Marreros Guzmán <admin@decodecms.com>
 */


require_once VLFC_DIR . 'includes/class-video-list-for-courses-post-type.php';
require_once VLFC_DIR . 'includes/class-video-list-for-courses-admin-table.php';
require_once VLFC_DIR . 'helpers/functions.php';


class VLFC_Video_List_For_Courses_Admin {
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the custom post type
	 *
	 * @since    1.0.0
	 */
	public function vlfc_register_post_type(){
		VLFC_CPT::register_post_type();
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function vlfc_enqueue_styles() {
		if ( $this->is_page_vlfc() ){
			wp_enqueue_style( $this->plugin_name, VLFC_URL . 'admin/css/video-list-for-courses-admin.css', array(), $this->version, 'all' );			
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function vlfc_enqueue_scripts() {
		if ( $this->is_page_vlfc() ){
			wp_enqueue_script( $this->plugin_name, VLFC_URL . 'admin/js/video-list-for-courses-admin.js', array( 'jquery' ), $this->version, false );
		}
	}

	/**
	 * Create main item and subitems menu
	 *
	 * @since    1.0.0
	 */
	public function vlfc_admin_menu() {
		global $_wp_last_object_menu;

		$_wp_last_object_menu++;
		
		add_menu_page( __( 'Video List Courses', 'video-list-for-courses' ),
					   __( 'Video Courses', 'video-list-for-courses' ),
					   'manage_options', 
					   'vlfc',
					   array( $this, 'vlfc_admin_management_page' ), 
					   'dashicons-playlist-video',
					   $_wp_last_object_menu++);


		$edit = add_submenu_page( 'vlfc',
						__( 'Edit Video Courses', 'video-list-for-courses' ),
						__( 'Video List Courses', 'video-list-for-courses' ),
						'manage_options', 
						'vlfc',
						array( $this, 'vlfc_admin_management_page') );

		add_action( 'load-' . $edit, array( $this, 'vlfc_load_admin_edit_page' ) ); //load before show edit page


		add_submenu_page( 'vlfc',
						__( 'Add New Video Course', 'video-list-for-courses' ),
						__( 'Add New', 'video-list-for-courses' ),
						'manage_options', 
						'vlfc-new',
						array($this, 'vlfc_admin_new_page') );

	}

	/**
	 * Shows principal content item menu, alsa shows detail course for editing
	 *
	 * @since    1.0.0
	 */
	public function vlfc_admin_management_page() {

		// edit course
		if ( $course = VLFC_CPT::get_current() ){

			include_once VLFC_DIR . 'admin/partials/admin-edit.php';

		}
		// list courses
		else {

			$list_table = new VLFC_Video_List_For_Courses_Admin_Table();
			$list_table->prepare_items();
			
			include_once VLFC_DIR . 'admin/partials/admin-display.php';			
		}

	}

	/**
	 * Shows new content page for a course
	 *
	 * @since    1.0.0
	 */
	public function vlfc_admin_new_page() {
		//create new course object 
		$course = VLFC_CPT::get_instance(0); 
		
		include_once VLFC_DIR . 'admin/partials/admin-edit.php';
	}


	/**
	 * load before, edit page content page for a course
	 *
	 * @since    1.0.0
	 */
	public function vlfc_load_admin_edit_page() {
		$action = vlfc_current_action();

		if ($action == 'edit') {
			$id = $_GET['post'] ;
			VLFC_CPT::get_instance( $id );
		}
		
	}

	/*
	Actions functions, New, Edit, Delete, Duplicate
	-----------------------------------------------
	*/

	/**
	 *  Save new Course
	 *
	 * @since    1.0.0
	 */
	public function vlfc_new_course(){

		$args = $this->get_args_parameters();
		
		// Insert new course in  wp_post table
		$course_id = wp_insert_post( $args , true );

		// Get link redirection
		$link = $this->get_link_redirection( $course_id );

		wp_redirect( $link );
		exit;

	} // --  vlfc_new_course --

	
	/**
	 *  Edit a Course
	 *
	 * @since    1.0.0
	 */
	public function vlfc_edit_course(){

		$args = $this->get_args_parameters();
		
		// Update course in  wp_post table
		$course_id = wp_update_post( $args , true );

		// Get link redirection
		$link = $this->get_link_redirection( $course_id );

		wp_redirect( $link );
		exit;

	} // --  vlfc_edit_course --


	/**
	 *  Delete a course from the wp_posts table
	 *
	 * @since    1.0.0
	 */
	public function vlfc_delete_course(){

		$course_id = $_REQUEST['course_id'];
		$course_wpnonce = $_REQUEST['_wpnonce'];
		$nonce_name = 'vlfc-delete-course_';

		if ( ! isset( $course_wpnonce ) || 
			 ! wp_verify_nonce( $course_wpnonce, $nonce_name . $course_id ) ) {
			die("Security check, not valid nonce 🖐");
		}

	    $course = wp_delete_post($course_id, true); //return a post object , or false

	    // TODO : reportar mensaje de eliminado correctamente.
	    

	} // -- vlfc_delete_course --

	public function vlfc_duplicate_course(){
		status_header(200);
	    die("Server received '{$_REQUEST['action']}' from your browser.");
	}
	/*
	-----------------------------------------------
	*/


	/**
	 * Shows the messages, success and failed, 
	 * based in the Hook: vlfc_admin_messages
	 *
	 * @since    1.0.0
	 */
	public function vlfc_admin_show_message() {

		if ( empty( $_REQUEST['state'] ) ) {
			return;
		}

		if ( 'success' == $_REQUEST['state'] ) {
			$updated_message = __( "Course Saved.", "video-list-for-courses" );
			echo sprintf( '<div id="message" class="updated notice notice-success is-dismissible"><p>%s</p></div>', esc_html( $updated_message ) );
		}

		if ( 'failed' == $_REQUEST['state'] ) {
			$fail_message = isset( $_REQUEST['message'] ) ? " " . $_REQUEST['message'] : '' ;
			$updated_message = __( "There was an error saving the course.", "video-list-for-courses" );
			echo sprintf( '<div id="message" class="notice notice-error is-dismissible"><p>%s</p></div>', esc_html( $updated_message ).$fail_message  );
		}

	}


	/**
	 * validate if we are in a vlfc page, for loading scripts
	 *
	 * @since    1.0.0
	 */
	private function is_page_vlfc(){

		if ( isset($_REQUEST['page']) ){
			$page = $_REQUEST['page'];
			return ($page == 'vlfc' || $page == 'vlfc-new');	
		}
		return false;

	}

	/**
	* Get args for insert and edit course
	*
	* @since    1.0.0
	*/
	private function get_args_parameters() {

		$course_id = $_REQUEST['course_id'];
		$course_title = $_REQUEST['course_title'];
		$course_content = $_REQUEST['course_content'];
		$course_wpnonce = $_REQUEST['_wpnonce'];
		$nonce_name = 'vlfc-save-course_';

		if ( ! isset( $course_wpnonce ) || 
			 ! wp_verify_nonce( $course_wpnonce, $nonce_name . $course_id ) ) {
			die("Security check, not valid nonce 🖐");
		}

		$args = [
			'ID' => $course_id,
			'post_title' => $course_title,
			'post_content' => $course_content,
			'post_status' => 'publish',
			'post_type' => 'vlfc_video_courses'
		];

		return $args;
	}

	/**
	*  Validate the parameter $course_id, if it's a number, it's ok, report success
	*  if it's and error object report the error, finally it return the link
	*
	* @since    1.0.0
	*/
	private function get_link_redirection( $course_id ) {

		if ( ! is_wp_error( $course_id ) ){
			$url = admin_url( 'admin.php?page=vlfc&post=' . absint( $course_id ) ); 
			$link = add_query_arg( array( 'action' => 'edit', 'state' => 'success' ), $url );
		}
		else {
			$url = admin_url( 'admin.php?page=vlfc-new' ); 
			$link = add_query_arg( array( 'state' => 'failed' , 'message' => urlencode($course_id->get_error_message()) ), $url );
		}

		return $link;
	}



}
