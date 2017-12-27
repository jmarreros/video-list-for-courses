<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://decodecms.com
 * @since      1.0.0
 *
 * @package    Video_List_For_Courses
 * @subpackage Video_List_For_Courses/admin/partials
 */

include_once VLFC_DIR . 'includes/class-video-list-for-courses-post-type.php';
?>


<div class="wrap">

<h1 class="wp-heading-inline"><?php
	echo esc_html( __( 'Video List For Courses', 'video-list-for-courses' ) );
?></h1>


<?php

	echo sprintf( '<a href="%1$s" class="add-new-h2">%2$s</a>',
		esc_url( menu_page_url( 'vlfc-new', false ) ),
		esc_html( __( 'Add New', 'video-list-for-courses' ) ) );

	if ( ! empty( $_REQUEST['s'] ) ) {
		echo sprintf( '<span class="subtitle">'
			. __( 'Search results for &#8220;%s&#8221;', 'contact-form-7' )
			. '</span>', esc_html( $_REQUEST['s'] ) );
	}
?>

<hr class="wp-header-end">


<?php 
	// Show messages for the user
	do_action( 'vlfc_admin_messages' ); 
?>

<form method="get" action="">
	<input type="hidden" name="page" value="<?php echo esc_attr( $_REQUEST['page'] ); ?>" />
	<?php $list_table->search_box( __( 'Search Courses', 'video-list-for-courses' ), 'vlfc_search' ); ?>
	<?php $list_table->display(); ?>
</form>


</div>

