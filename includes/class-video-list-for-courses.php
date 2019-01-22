<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://decodecms.com
 * @since      1.0.0
 *
 * @package    Video_List_For_Courses
 * @subpackage Video_List_For_Courses/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Video_List_For_Courses
 * @subpackage Video_List_For_Courses/includes
 * @author     Jhon Marreros Guzmán <admin@decodecms.com>
 */
class VLFC_Video_List_For_Courses {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Video_List_For_Courses_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		$this->version = VLFC_VERSION;
		$this->plugin_name = VLFC_NAME;

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Video_List_For_Courses_Loader. Orchestrates the hooks of the plugin.
	 * - Video_List_For_Courses_i18n. Defines internationalization functionality.
	 * - Video_List_For_Courses_Admin. Defines all hooks for the admin area.
	 * - Video_List_For_Courses_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		require_once VLFC_DIR . 'includes/class-video-list-for-courses-loader.php';
		require_once VLFC_DIR . 'includes/class-video-list-for-courses-i18n.php';
		require_once VLFC_DIR . 'admin/class-video-list-for-courses-admin.php';
		require_once VLFC_DIR . 'public/class-video-list-for-courses-public.php';

		$this->loader = new VLFC_Video_List_For_Courses_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Video_List_For_Courses_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new VLFC_Video_List_For_Courses_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new VLFC_Video_List_For_Courses_Admin( $this->get_plugin_name(), $this->get_version() );

		//general hooks
		// $this->loader->add_action( 'init', $plugin_admin, 'vlfc_register_post_type');
		// $this->loader->add_action( 'init', $plugin_admin, 'vlfc_register_taxonomy');

		$this->loader->add_action( 'admin_init', $plugin_admin, 'vlfc_register_settings');
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'vlfc_admin_menu');
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'vlfc_enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'vlfc_enqueue_scripts' );

		//actions hooks
		$this->loader->add_action( 'vlfc_admin_messages', $plugin_admin, 'vlfc_admin_show_message' );
		$this->loader->add_action( 'admin_post_vlfc_edit_action', $plugin_admin, 'vlfc_edit_course' );
		$this->loader->add_action( 'admin_post_vlfc_new_action', $plugin_admin, 'vlfc_new_course' );
		$this->loader->add_action( 'admin_post_vlfc_delete_action', $plugin_admin, 'vlfc_delete_course' );
		$this->loader->add_action( 'admin_post_vlfc_duplicate_action', $plugin_admin, 'vlfc_duplicate_course' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new VLFC_Video_List_For_Courses_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'vlfc_register_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'vlfc_register_scripts' );

		$this->loader->add_action( 'init', $plugin_public, 'vlfc_register_shortcode_course');
		$this->loader->add_action( 'init', $plugin_public, 'vlfc_register_shortcode_list_courses');

		$this->loader->add_action( 'wp_ajax_nopriv_vlfc_ajax_get_data', $plugin_public, 'vlfc_ajax_get_data_object' );
		$this->loader->add_action( 'wp_ajax_vlfc_ajax_get_data', $plugin_public, 'vlfc_ajax_get_data_object' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Video_List_For_Courses_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
