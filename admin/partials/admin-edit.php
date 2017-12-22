<?php

/**
 * Provide a edit and new page for the course
 *
 * This file is used to markup the edit an new page
 *
 * @link       https://decodecms.com
 * @since      1.0.0
 *
 * @package    Video_List_For_Courses
 * @subpackage Video_List_For_Courses/admin/partials
 */

//include_once VLFC_DIR . 'includes/class-video-list-for-courses-post-type.php';
?>

<div class="wrap">

<h1 class="wp-heading-inline"><?php
	if ( $course->initial() ) {
		echo esc_html( __( 'Add New Course', 'video-list-for-courses' ) );
	} else {
		echo esc_html( __( 'Edit Course', 'video-list-for-courses' ) );
	}
?></h1>

<hr class="wp-header-end">
