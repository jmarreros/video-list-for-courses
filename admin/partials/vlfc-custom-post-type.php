<?php

/**
 * Custom post type for the plugin
 *
 * @link       https://decodecms.com
 * @since      1.0.0
 *
 * @package    Video_List_For_Courses
 * @subpackage Video_List_For_Courses/admin/partials
 */


// Register Custom Post Type
// function vlfc_custom_post_type() {

// 	$labels = array(
// 		'name'                  => _x( 'Video List Courses', 'Post Type General Name', 'video-list-for-courses' ),
// 		'singular_name'         => _x( 'Video List Course', 'Post Type Singular Name', 'video-list-for-courses' ),
// 		'menu_name'             => __( 'VideoListCourses', 'video-list-for-courses' ),
// 		'name_admin_bar'        => __( 'VideoListCourses', 'video-list-for-courses' ),
// 		'archives'              => __( 'Item Archives', 'video-list-for-courses' ),
// 		'attributes'            => __( 'Item Attributes', 'video-list-for-courses' ),
// 		'parent_item_colon'     => __( 'Parent Item:', 'video-list-for-courses' ),
// 		'all_items'             => __( 'All Items', 'video-list-for-courses' ),
// 		'add_new_item'          => __( 'Add New Item', 'video-list-for-courses' ),
// 		'add_new'               => __( 'Add New', 'video-list-for-courses' ),
// 		'new_item'              => __( 'New Item', 'video-list-for-courses' ),
// 		'edit_item'             => __( 'Edit Item', 'video-list-for-courses' ),
// 		'update_item'           => __( 'Update Item', 'video-list-for-courses' ),
// 		'view_item'             => __( 'View Item', 'video-list-for-courses' ),
// 		'view_items'            => __( 'View Items', 'video-list-for-courses' ),
// 		'search_items'          => __( 'Search Item', 'video-list-for-courses' ),
// 		'not_found'             => __( 'Not found', 'video-list-for-courses' ),
// 		'not_found_in_trash'    => __( 'Not found in Trash', 'video-list-for-courses' ),
// 		'featured_image'        => __( 'Featured Image', 'video-list-for-courses' ),
// 		'set_featured_image'    => __( 'Set featured image', 'video-list-for-courses' ),
// 		'remove_featured_image' => __( 'Remove featured image', 'video-list-for-courses' ),
// 		'use_featured_image'    => __( 'Use as featured image', 'video-list-for-courses' ),
// 		'insert_into_item'      => __( 'Insert into item', 'video-list-for-courses' ),
// 		'uploaded_to_this_item' => __( 'Uploaded to this item', 'video-list-for-courses' ),
// 		'items_list'            => __( 'Items list', 'video-list-for-courses' ),
// 		'items_list_navigation' => __( 'Items list navigation', 'video-list-for-courses' ),
// 		'filter_items_list'     => __( 'Filter items list', 'video-list-for-courses' ),
// 	);
// 	$args = array(
// 		'label'                 => __( 'Video List Course', 'video-list-for-courses' ),
// 		'description'           => __( 'CPT for Video List Courses', 'video-list-for-courses' ),
// 		'labels'                => $labels,
// 		'supports'              => array( 'title', 'thumbnail', 'custom-fields' ),
// 		'hierarchical'          => false,
// 		'public'                => true,
// 		'show_ui'               => false,
// 		'show_in_menu'          => false,
// 		'menu_position'         => 5,
// 		'show_in_admin_bar'     => false,
// 		'show_in_nav_menus'     => false,
// 		'can_export'            => true,
// 		'has_archive'           => false,
// 		'exclude_from_search'   => true,
// 		'publicly_queryable'    => false,
// 		'rewrite'               => false,
// 		'capability_type'       => 'post',
// 		'show_in_rest'          => false,
// 	);
// 	register_post_type( 'videolistcourses', $args );

// }
// add_action( 'init', 'vlfc_custom_post_type', 0 );
