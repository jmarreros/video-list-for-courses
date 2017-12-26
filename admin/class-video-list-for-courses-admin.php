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
	*/
	public function vlfc_edit_course(){
		status_header(200);
	    die("Server received '{$_REQUEST['action']}' from your browser.");
	}

	public function vlfc_new_course(){
		status_header(200);
	    die("Server received '{$_REQUEST['action']}' from your browser.");
	}

	public function vlfc_delete_course(){
		status_header(200);
	    die("Server received '{$_REQUEST['action']}' from your browser.");
	}

	public function vlfc_duplicate_course(){
		status_header(200);
	    die("Server received '{$_REQUEST['action']}' from your browser.");
	}


	public function vlfc_admin_show_message() {

		// if ( empty( $_REQUEST['message'] ) ) {
		// 	return;
		// }

		echo "Mensaje desde hook ".$_REQUEST['message'];
		return;
	}


	/**
	 * validate if we are in a vlfc page, for loading scripts
	 *
	 * @since    1.0.0
	 */
	private function is_page_vlfc(){
		$page = $_REQUEST['page'];
		return ($page == 'vlfc' || $page == 'vlfc-new');
	}

}
