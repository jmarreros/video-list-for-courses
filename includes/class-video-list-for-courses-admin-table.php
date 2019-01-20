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


require_once VLFC_DIR . 'includes/class-video-list-for-courses-post-type.php';


class VLFC_Video_List_For_Courses_Admin_Table extends WP_List_Table{

	function __construct() {
		parent::__construct( array(
			'singular' => 'course',
			'plural' => 'courses',
			'ajax' => false,
		) );
	}

	// -- General functions columns
	public function get_columns() {
		//$this->screen->post_type;
		$columns = array(
			'cb' => '',
			'title' => __( 'Courses', 'video-list-for-courses' ),
			'shortcode' => __( 'Shortcode', 'video-list-for-courses' ),
			'order' => __( 'Order', 'video-list-for-courses' ),
			'author' => __( 'Author', 'video-list-for-courses' ),
			'date' => __( 'Date', 'video-list-for-courses' )
		);

		return $columns;
	}

	// function get_columns() {
	// 	return get_column_headers( get_current_screen() );
	// }

	function get_sortable_columns() {
		$columns = array(
			'title' => array( 'title', true ),
			'author' => array( 'author', false ),
			'date' => array( 'date', false ),
			'order' => array( 'order', false )
		);

		return $columns;
	}

	// -- End General functions columns --

	function get_bulk_actions() {
		$actions = array(
			'delete' => __( 'Delete', 'video-list-for-courses' ),
		);

		return $actions;
	}

	function prepare_items() {
		//$current_screen = get_current_screen();
		$per_page = 20;

		$columns = $this->get_columns();
		$hidden = array();
		$sortable = $this->get_sortable_columns();

		$this->_column_headers = array($columns, $hidden, $sortable);

		$args = array(
			'posts_per_page' => $per_page,
			'orderby' => 'title',
			'order' => 'ASC',
			'offset' => ( $this->get_pagenum() - 1 ) * $per_page,
		);

		//for searching
		if ( ! empty( $_REQUEST['s'] ) ) {
			$args['s'] = $_REQUEST['s'];
		}

		//order
		if ( ! empty( $_REQUEST['orderby'] ) ) {
			if ( 'title' == $_REQUEST['orderby'] ) {
				$args['orderby'] = 'title';
			} elseif ( 'author' == $_REQUEST['orderby'] ) {
				$args['orderby'] = 'author';
			} elseif ( 'order' == $_REQUEST['orderby'] ) {
				$args['orderby'] = 'order';
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

		// execute the query
		$this->items = VLFC_CPT::find( $args );

		$total_items = VLFC_CPT::count();
		$total_pages = ceil( $total_items / $per_page );


		$this->set_pagination_args( array(
			'total_items' => $total_items,
			'total_pages' => $total_pages,
			'per_page' => $per_page,
		) );
	}

	//-- Especific columns

	function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="%1$s[]" value="%2$s" />',
			$this->_args['singular'],
			$item->id() );
	}

	function column_title( $item ) {

		//link
		$url = admin_url( 'admin.php?page=vlfc&post=' . absint( $item->id() ) ); // vlfc -> add_menu
		$edit_link = add_query_arg( array( 'option' => 'edit' ), $url );

		$output = sprintf(
			'<strong><a class="row-title" href="%1$s" title="%2$s">%3$s</a></strong>',
			esc_url( $edit_link ),
			esc_attr( sprintf( __( 'Edit &#8220;%s&#8221;', 'video-list-for-courses' ), $item->title() ) ),
			esc_html( $item->title() )
		);

		// actions
		$course_id = absint( $item->id() );
		$url_duplicate = add_query_arg( array( 'action' => 'vlfc_duplicate_action', 'course_id' => $course_id ), admin_url('admin-post.php') ); //admin-post.php
		$duplicate_link = wp_nonce_url( $url_duplicate, 'vlfc-save-course_' . $course_id );

		$actions = array(
						'edit' => sprintf( '<a href="%1$s">%2$s</a>',
											esc_url( $edit_link ),
											esc_html( __( 'Edit', 'video-list-for-courses' ) ) ),
						'duplicate' => sprintf('<a href="%1$s">%2$s</a>',
											esc_url( $duplicate_link ),
											esc_html( __( 'Duplicate', 'video-list-for-courses' ) ) )
						);


		$output .= $this->row_actions( $actions );

		return $output;
	}

	function column_order( $item ){
		return get_post_meta($item->id(), VLFC_ORDER, true);
	}

	function column_author( $item ) {
		$course = get_post( $item->id() );

		if ( ! $course ) {
			return;
		}

		$author = get_userdata( $course->post_author );

		if ( false === $author ) {
			return;
		}

		return esc_html( $author->display_name );
	}

	function column_shortcode( $item ) {
		return '['.VLFC_SHORTCODE.' id='.$item->id() . ']';
	}

	function column_date( $item ) {
		$course = get_post( $item->id() );

		if ( ! $course ) {
			return;
		}

		$t_time = mysql2date( __( 'Y/m/d g:i:s A', 'video-list-for-courses' ), $course->post_date, true );
		$h_time = mysql2date( __( 'd/m/Y', 'video-list-for-courses' ), $course->post_date, true );

		return '<abbr title="' . $t_time . '">' . $h_time . '</abbr>';
	}

	//-- End Especific columns

}