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
?>


<div class="wrap">

<h1 class="wp-heading-inline"><?php
	echo esc_html( __( 'Video List For Courses', 'video-list-for-courses' ) );
?></h1>

<hr class="wp-header-end">


<form method="get" action="">
	<input type="hidden" name="page" value="<?php echo esc_attr( $_REQUEST['page'] ); ?>" />
	<?php //$list_table->search_box( __( 'Search Courses', 'video-list-for-courses' ), 'wpcf7-contact' ); ?>
	<?php //$list_table->display(); ?>
</form>


</div>

