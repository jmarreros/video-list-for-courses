<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://decodecms.com
 * @since      1.0.0
 *
 * @package    Video_List_For_Courses
 * @subpackage Video_List_For_Courses/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and hooks to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Video_List_For_Courses
 * @subpackage Video_List_For_Courses/public
 * @author     Jhon Marreros Guzmán <admin@decodecms.com>
 */

require_once VLFC_DIR . 'includes/class-video-list-for-courses-post-type.php';
//require_once VLFC_DIR . 'helpers/functions.php';


class VLFC_Video_List_For_Courses_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function vlfc_register_styles() {
		wp_register_style( $this->plugin_name, VLFC_URL . 'public/css/video-list-for-courses.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function vlfc_register_scripts() {
		wp_register_script( $this->plugin_name, VLFC_URL . 'public/js/video-list-for-courses.js', array( 'jquery' ), $this->version, false );

		wp_localize_script( $this->plugin_name,'vlfc_vars',[
			'ajaxurl'=>admin_url('admin-ajax.php'),
			'ajax_nonce' => wp_create_nonce('vlf_data_ajax'),
			'assets_path' => VLFC_URL.'public/assets/'
		]);
	}

	/**
	 * Function to send Ajax data
	 *
	 * @since    1.0.0
	 */
	public function vlfc_ajax_get_data_object(){

		$item = absint($_POST['item']);
		$id_course = absint($_POST['course']);
		$islock = false;

		check_ajax_referer( 'vlf_data_ajax', 'security' ); //nonce validation

		$course = VLFC_CPT::get_instance( $id_course );

		if ( $course->id() > 0 ){


			$content = json_decode($course->content());
			$res = array ( 'name' => $content[$item]->name,
						   'code' =>  $content[$item]->code,
						   'notes' => $content[$item]->notes );


			$islock = $content[$item]->islock;

			if ( $islock && ! is_user_logged_in() ){
				wp_send_json_error('Access error, lock item 🔒🔒🔒');
			}

			wp_send_json_success($res);

		}


		wp_die();
	}


}
