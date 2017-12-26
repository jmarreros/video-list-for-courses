<?php

/**
 * Manage diferent actions 
 *
 * This file is used to control : new , edit, delete, duplicate courses
 *
 * @link       https://decodecms.com
 * @since      1.0.0
 *
 * @package    Video_List_For_Courses
 * @subpackage Video_List_For_Courses/admin/partials
 */


// Messages hook
add_action( 'vlfc_admin_messages', 'vlfc_admin_show_message' );

function vlfc_admin_show_message() {

	if ( empty( $_REQUEST['message'] ) ) {
		return;
	}

	// if ( 'failed' == $_REQUEST['message'] ) {
	// 	$updated_message = __( "There was an error saving the course.",
	// 		'contact-form-7' );

	// 	echo sprintf( '<div id="message" class="notice notice-error is-dismissible"><p>%s</p></div>', esc_html( $updated_message ) );
	// 	return;
	// }

	// if ( 'validated' == $_REQUEST['message'] ) {
	// }


	echo "Mensaje desde hook ".$_REQUEST['message'];
	return;

}


// add_action( 'admin_post_nopriv_vlfc_edit_course', 'vlfc_edit_course' );
// add_action( 'admin_post_vlfc_edit_course', 'vlfc_edit_course' );

add_action( 'admin_post_nopriv', 'vlfc_edit_course' );
add_action( 'admin_post', 'vlfc_edit_course' );


function vlfc_edit_course(){
	wp_redirect('https://google.com');
	exit;
}


