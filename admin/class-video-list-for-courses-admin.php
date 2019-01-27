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
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function vlfc_enqueue_styles() {
		if ( is_page_vlfc() ){
			wp_enqueue_style( $this->plugin_name, VLFC_URL . 'admin/css/video-list-for-courses-admin.css', array(), $this->version, 'all' );
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function vlfc_enqueue_scripts() {
		if ( is_page_vlfc() ){
			//wp_enqueue_script( 'vlfc_sortable', VLFC_URL . 'admin/js/sortable.min.js', null , $this->version, false );
			wp_enqueue_script( $this->plugin_name, VLFC_URL . 'admin/js/video-list-for-courses-admin.js', array( 'jquery' ), $this->version, false );

			$params = array (
				'assets_path' => VLFC_URL.'admin/assets/'
			);
			//pass values PHP to Javascript
			wp_localize_script($this->plugin_name,'vars_wp',$params);
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


		$list = add_submenu_page( 'vlfc',
						__( 'Courses List', 'video-list-for-courses' ),
						__( 'Courses List', 'video-list-for-courses' ),
						'manage_options',
						'vlfc',
						array( $this, 'vlfc_admin_management_page') );

		add_submenu_page( 'vlfc',
						__( 'Add New Video Course', 'video-list-for-courses' ),
						__( 'Add New', 'video-list-for-courses' ),
						'manage_options',
						'vlfc-new',
						array($this, 'vlfc_admin_management_page') );

		add_submenu_page( 'vlfc',
						__( 'Import', 'video-list-for-courses' ),
						__( 'Import', 'video-list-for-courses' ),
						'manage_options',
						'vlfc-import',
						array($this, 'vlfc_admin_management_page') );

		add_submenu_page('vlfc',
						__( 'Settings', 'video-list-for-courses' ),
						__( 'Settings', 'video-list-for-courses' ),
						'manage_options',
						'vlfc-set',
						array($this,'vlfc_show_settings' ));


		add_action( 'load-' . $list, array( $this, 'vlfc_load_video_list_for_courses' ) );

	}

	/**
	 * Shows principal content item menu, alsa shows detail course for editing
	 *
	 * @since    1.0.0
	 */
	public function vlfc_admin_management_page() {

		$option = vlfc_current_option();

		switch ( $option ) {
			case 'new':
				$course = VLFC_CPT::get_instance(0);
				include_once VLFC_DIR . 'admin/partials/admin-edit.php';
				break;

			case 'edit':
				$post_id = vlfc_current_post();
				if ( $post_id ){
					$course = VLFC_CPT::get_instance( $post_id );
					include_once VLFC_DIR . 'admin/partials/admin-edit.php';
				}
				break;
			case 'import':
				include_once VLFC_DIR . 'admin/partials/admin-import.php';
				break;
			default: // List courses
				$list_table = new VLFC_Video_List_For_Courses_Admin_Table();
				$list_table->prepare_items();
				include_once VLFC_DIR . 'admin/partials/admin-display.php';
				break;
		}

	}

	/**
	 * Shows the settings forms from the settings menu
	 *
	 * @since    1.0.0
	 */
	public function vlfc_show_settings(){
		include_once VLFC_DIR . 'admin/partials/admin-settings.php';
	}

	/**
	 * Register the fields for settings in admin_init hook
	 *
	 * @since    1.0.0
	 */
	public function vlfc_register_settings() {
	  register_setting( 'settings-video-list-for-courses', VLFC_OPTIONS );
	}


	/**
	 * For working with bulk action, delete
	 *
	 * @since    1.0.0
	 */
	public function vlfc_load_video_list_for_courses(){
		$bulk_action = current_bulk_action();

		if ( 'delete' == $bulk_action ){

			check_admin_referer('bulk-courses'); // validate nonce, "courses" plural from the constructor table

			if ( ! empty( $_REQUEST['course']) ){

				$courses = $_REQUEST['course']; //Delete array courses
				$i = 0;

				foreach ($courses as $course) {
					$course = VLFC_CPT::delete_course($course);
					if ( ! $course ) break;
					$i++;
				}

				if ( $i == count( $courses ) ){
					$message = sprintf( _n( '%d course deleted', '%d courses deleted', $i, 'video-list-for-courses' ), $i );
					$link = $this->get_link_redirection_delete( true , $message );
				} else {
					$message = __( 'Some courses could not be deleted' , 'video-list-for-courses' );
					$link = $this->get_link_redirection_delete( false, $message );
				}

			}
			else{
				$message = __( 'No courses selected', 'video-list-for-courses' );
				$link = $this->get_link_redirection_delete( false, $message );
			}

			wp_safe_redirect( $link );
			exit;

		} // delete bulk_action


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
		$this->option_save_course( 0 ); // 0 new course
	}

	/**
	 *  Edit a Course
	 *
	 * @since    1.0.0
	 */
	public function vlfc_edit_course(){
		$post_id = vlfc_current_post();
		$this->option_save_course( $post_id ); // $post_id edit course
	}

	/**
	 *  Duplicate a course in ta wp_posts table
	 *
	 * @since    1.0.0
	 */
	public function vlfc_duplicate_course(){
		$post_id = vlfc_current_post();
		$this->option_save_course( $post_id, true ); // $post_id , true for duplicating
	}


	/**
	 *  Auxiliar function for new, edit and duplicate course
	 *
	 * @since    1.0.0
	 */
	private function option_save_course( $id , $duplicate = false ){
		$course = VLFC_CPT::get_instance( $id ); // get and existing object o new object

		// validate nonce
		$nonce_name = 'vlfc-save-course_' . $course->id();
		$this->validate_nonce( $nonce_name );

		if ( $duplicate ){
			// change values
			$course->set_id(0);
			$course->set_title( $course->title() . ' - Copy');
			$course->set_thumbnail( $course->thumbnail() );
			$course->set_order( $course->order() );
			$course->set_description( $course->description() );
			$course->set_showlist( false );
			$course->set_linkpage('');
			$course->set_label('');
		}
		else{
			// fill values
			$course->set_title( $_REQUEST['course_title'] );
			$course->set_content( $_REQUEST['course_content'] );
			$course->set_thumbnail( $_REQUEST['vlfc-thumbnail'] );
			$course->set_order( $_REQUEST['vlfc-order'] );
			$course->set_description( $_REQUEST['vlfc-description'] );
			$course->set_showlist( $_REQUEST['vlfc-show-list'] );
			$course->set_linkpage( $_REQUEST['vlfc-link-page'] );
			$course->set_label( $_REQUEST['vlfc-label'] );

		}

		// insert or update
		$course_id = $course->save_course();

		// Get link redirection
		$link = $this->get_link_redirection_save( $course_id );

		wp_safe_redirect( $link );
		exit;
	}

	/**
	 *  Delete a course from the wp_posts table
	 *
	 * @since    1.0.0
	 */
	public function vlfc_delete_course(){

		$course_id = vlfc_current_post();

		// validate nonce
		$nonce_name = 'vlfc-delete-course_' . $course_id;
		$this->validate_nonce( $nonce_name );

		//return a post object , or false, second parameter to force delete
	    $course = VLFC_CPT::delete_course( $course_id );

	    $link = $this->get_link_redirection_delete( $course );

	    wp_safe_redirect( $link );
		exit;

	} // -- vlfc_delete_course --


	/**
	 *  Export a course wp_posts and wp_post_meta tables
	 *
	 * @since    1.0.0
	 */
	public function vlfc_export_course(){
		$course_id = vlfc_current_post();

		// validate nonce
		$nonce_name = 'vlfc-export-course_' . $course_id;
		$this->validate_nonce( $nonce_name );

		$course = VLFC_CPT::get_instance( $course_id );

		// Validation CPT exists
		if ( $course->initial() ){
			exit("Not valid CPT id 👈");
		}

		$file_name = $course->title;
		$course = json_encode($course);

		include_once VLFC_DIR . 'admin/partials/admin-export.php';

		exit;
	}


	/**
	 *  Export a course wp_posts and wp_post_meta tables
	 *
	 * @since    1.0.0
	 */
	public function vlfc_import_course(){

		if( isset($_POST["submit"]) ){
			$tmp_dir = get_temp_dir();
			$file_name = $tmp_dir . basename($_FILES["fileToUpload"]["name"]);
			$file_type = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));

			// Validation
			if ( $file_type != 'json' || ! move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $file_name) ){
				$link = $this->get_link_redirection_import( false );
				wp_safe_redirect( $link );
				exit;
			}

			// Get content file uploaded
			$content = file_get_contents($file_name);
			unlink($file_name); //remove file


			echo $content;
		}


		// $link = $this->get_link_redirection_import( true );
		// wp_safe_redirect( $link );
		exit;
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

		switch ( $_REQUEST['state'] ) {
			case 'success':
					$message = __( "Saved.", "video-list-for-courses" );
					$message = isset( $_REQUEST['message'] ) && ! empty($_REQUEST['message']) ? $_REQUEST['message'] : $message ;
					echo sprintf( '<div id="message" class="updated notice notice-success is-dismissible"><p>%s</p></div>', esc_html( $message ) );
					break;
			case 'failed':
					$message = __( "There was an error.", "video-list-for-courses" );
					$message = isset( $_REQUEST['message']) && ! empty($_REQUEST['message']) ? $_REQUEST['message'] : $message ;
					echo sprintf( '<div id="message" class="notice notice-error is-dismissible"><p>%s</p></div>', esc_html( $message ) );
					break;
		}

	}


	/**
	*  Security funcion for validating nonces
	*
	* @since    1.0.0
	*/
	private function validate_nonce( $nonce_name ) {
		$course_wpnonce = $_REQUEST['_wpnonce'];

		if ( ! isset( $course_wpnonce ) ||
			 ! wp_verify_nonce( $course_wpnonce, $nonce_name ) ) {
			die("Security check, not valid nonce 🖐");
		}
	}

	/**
	*  Validate the parameter $course_id, if it's a number, it's ok, report success
	*  if it's and error object report the error, finally it return the link
	*
	* @since    1.0.0
	*/
	private function get_link_redirection_save( $course_id ) {

		if ( ! is_wp_error( $course_id ) ) {
			$message = __( "Course saved.", "video-list-for-courses" );
			$url = admin_url( 'admin.php?page=vlfc&post=' . absint( $course_id ) );
			$link = add_query_arg( array( 'option' => 'edit', 'state' => 'success', 'message' => urlencode($message) ), $url );
		}
		else {
			$url = admin_url( 'admin.php?page=vlfc-new' );
			$link = add_query_arg( array( 'state' => 'failed' , 'message' => urlencode($course_id->get_error_message()) ), $url );
		}

		return $link;
	}

	/**
	*  Validate the object delete, if it's an object, it's ok, report success
	*  if it's false, report the error, finally it return the link
	*
	* @since    1.0.0
	*/
	private function get_link_redirection_delete( $delete, $message = '' ){
		$url = admin_url( 'admin.php?page=vlfc' );

		if ( $delete ) {
			$message = empty( $message ) ? __( "The course was removed", "video-list-for-courses" ) : $message;
			$link = add_query_arg( array( 'state' => 'success', 'message' => urlencode($message) ), $url );
		}
		else {
			$link = add_query_arg( array( 'state' => 'failed', 'message' => urlencode($message) ), $url );
		}

		return $link;
	}


	private function get_link_redirection_import($imported){
		$url = admin_url( 'admin.php?page=vlfc-import' );

		if ( $imported ) {
			$message = __( "The course was imported", "video-list-for-courses" );
			$link = add_query_arg( array( 'state' => 'success', 'message' => urlencode($message) ), $url );
		}
		else {
			$message = __( "The course was not imported", "video-list-for-courses" );
			$link = add_query_arg( array( 'state' => 'failed', 'message' => urlencode($message) ), $url );
		}

		return $link;
	}



}
