<?php

/**
 * The admin-table specific functionality for showing the admin table
 *
 * @link       https://decodecms.com
 * @since      1.0.0
 *
 * @package    Video_List_For_Courses
 * @subpackage Video_List_For_Courses/admin/includes
 */

/**
 * The admin table in dashboard
 *
 * The admin-table specific functionality for showing the admin table
 * list all the registered courses
 *
 * @package    Video_List_For_Courses
 * @subpackage Video_List_For_Courses/admin/includes
 * @author     Jhon Marreros Guzmán <admin@decodecms.com>
 */

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}


class VLFC_Video_List_For_Courses_Admin_Table extends WP_List_Table{

	public static function define_columns() {
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => __( 'Courses', 'video-list-for-courses' ),
			'shortcode' => __( 'Shortcode', 'video-list-for-courses' ),
			'lock' => __( 'Lock', 'video-list-for-courses' ),
			'date' => __( 'Date', 'video-list-for-courses' ),
			'author' => __( 'Author', 'video-list-for-courses' ),
		);

		return $columns;
	}

	function __construct() {
		parent::__construct( array(
			'singular' => 'post',
			'plural' => 'posts',
			'ajax' => false,
		) );
	}

	function prepare_items() {
		$current_screen = get_current_screen();
		$per_page = 20;

		$this->_column_headers = $this->get_column_info();

		$args = array(
			'posts_per_page' => $per_page,
			'orderby' => 'title',
			'order' => 'ASC',
			'offset' => ( $this->get_pagenum() - 1 ) * $per_page,
		);

		if ( ! empty( $_REQUEST['s'] ) ) {
			$args['s'] = $_REQUEST['s'];
		}

		if ( ! empty( $_REQUEST['orderby'] ) ) {
			if ( 'title' == $_REQUEST['orderby'] ) {
				$args['orderby'] = 'title';
			} elseif ( 'author' == $_REQUEST['orderby'] ) {
				$args['orderby'] = 'author';
			} elseif ( 'date' == $_REQUEST['orderby'] ) {
				$args['orderby'] = 'date';
			}
		}

		if ( ! empty( $_REQUEST['order'] ) ) {
			if ( 'asc' == strtolower( $_REQUEST['order'] ) ) {
				$args['order'] = 'ASC';
			} elseif ( 'desc' == strtolower( $_REQUEST['order'] ) ) {
				$args['order'] = 'DESC';
			}
		}

		// TODO: Falta llenar los datos


		// $this->items = WPCF7_ContactForm::find( $args );

		// $total_items = WPCF7_ContactForm::count();
		// $total_pages = ceil( $total_items / $per_page );

		$total_items = 20;
		$total_pages = 2;

		$this->set_pagination_args( array(
			'total_items' => $total_items,
			'total_pages' => $total_pages,
			'per_page' => $per_page,
		) );
	}

}