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

// include_once VLFC_DIR . 'admin/partials/admin-actions.php';

?>

<div class="wrap">

<h1 class="wp-heading-inline"><?php
	if ( $course->initial() ) {
		echo esc_html( __( 'Add New Course', 'video-list-for-courses' ) );
	} else {
		echo esc_html( __( 'Edit Course', 'video-list-for-courses' ) );
	}
	$course_id = $course->id();
?></h1>

<hr class="wp-header-end">


<?php 
	// Show messages for the user
	do_action( 'vlfc_admin_messages' ); 
?>

<form method="get" 
	action="<?php echo admin_url('admin-post.php'); ?>"
	id="vlfc-admin-form-element" >


	<input type="hidden" id="course_id" name="course_id" value="<?php echo (int) $course_id; ?>" />
	<input type="hidden" id="action" name="action" value="" />
	<input type="hidden" id="_wpnonce" name="_wpnonce" value="" />


<div id="poststuff">
<div id="post-body" class="metabox-holder columns-2">
<div id="post-body-content">
<div id="titlediv">
<div id="titlewrap">

	<label class="screen-reader-text" id="title-prompt-text" for="title">
		<?php echo esc_html( __( 'Enter title here', 'video-list-for-courses' ) ); ?>
	</label>

	<input 
		name="course_title" 
		size="30" 
		value="<?php echo $course->initial() ? '' : $course->title(); ?>" 
		id="title" 
		spellcheck="true" 
		autocomplete="off" 
		required
		type="text" 
	/>

</div><!-- #titlewrap -->

<?php if ( $course_id ): ?>
	<div class="inside shortcode">
	<?php 
		// Show Shortcode
		echo __( 'Copy and paste this shortcode in a entry content:', 'video-list-for-courses' );
		echo " <strong>[ ".VLFC_SHORTCODE." id=".$course_id." ]</strong>";
	?>
	</div><!-- inside -->
<?php endif; ?>

</div><!-- #titlediv -->

<div id="wp-content-editor-container" class="wp-editor-container">

	<textarea class="wp-editor-area" 
			autocomplete="off" 
			cols="40" 
			name="course_content" 
			id="content"><?php echo $course->initial() ? '' : $course->content(); ?></textarea>

</div><!-- wp-content-editor-container -->

	<?php include VLFC_DIR . '/admin/partials/admin-list.php';?>
</div><!-- #post-body-content -->



<!------ Lateral Box ------>
<!-- ------------------- --> 
<div id="postbox-container-1" class="postbox-container">

	<div id="submitdiv" class="postbox">
	<h3><?php echo esc_html( __( 'Status', 'video-list-for-courses' ) ); ?></h3>

	<div class="inside">
	<div class="submitbox" id="submitpost">

		<div id="minor-publishing-actions"> 			
		
			<div id="duplicate-action">
			<?php
				if ( ! $course->initial() ) :
					$nonce_duplicate = wp_create_nonce( 'vlfc-save-course_' . $course_id );
					$action_duplicate = 'vlfc_duplicate_action'; 
			?>			
					<input type="submit" 
							name="vlfc-copy" 
							class="copy button" 
							value="<?php echo esc_attr( __( 'Duplicate', 'video-list-for-courses' ) ); ?>" 
							<?php echo "onclick=\"this.form._wpnonce.value = '$nonce_duplicate'; this.form.action.value = '$action_duplicate'; return true;\""; ?> 
					/>

			<?php endif; ?>
			</div><!-- #duplicate-action -->

		</div><!-- #minor-publishing-actions -->

		<div id="major-publishing-actions">
			
			<?php
				if ( ! $course->initial() ) :
					$nonce_delete = wp_create_nonce( 'vlfc-delete-course_' . $course_id );
					$action_delete = 'vlfc_delete_action'; 
			?>
				<div id="delete-action">
					<input type="submit" 
							name="vlfc-delete"
							class="delete submitdelete" 
							value="<?php echo esc_attr( __( 'Delete', 'video-list-for-courses' ) ); ?>" 
							<?php echo "onclick=\"if (confirm('" . esc_js( __( "You are about to delete this course.\n  'Cancel' to stop, 'OK' to delete.", 'video-list-for-courses' ) ) . "')) {this.form._wpnonce.value = '$nonce_delete'; this.form.action.value = '$action_delete'; return true;} return false;\""; ?> />
				</div><!-- #delete-action -->
			<?php endif; ?>

			<div id="publishing-action">
				<span class="spinner"></span>
				<?php 
					$nonce_save = wp_create_nonce( 'vlfc-save-course_' . $course_id );
					$action_save = $course->initial() ? 'vlfc_new_action' : 'vlfc_edit_action'; 
				?>
				<input type="submit" 
						class="button-primary" 
						name="vlfc-save"
						id = "vlfc-save"
						value="<?php echo esc_attr( __( 'Save', 'video-list-for-courses' )) ?>"						
						<?php echo "onclick=\"this.form._wpnonce.value = '$nonce_save'; this.form.action.value = '$action_save'; return true;\""; ?> />
			</div><!-- #publishing-action -->


			<div class="clear"></div>


		</div><!-- #major-publishing-actions -->

	</div><!-- #submitpost -->
	</div><!-- inside -->

	</div><!-- #submitdiv -->


</div><!-- #postbox-container-1 -->

<!------ End Lateral Box ------>
<!-- ----------------------- --> 



</div><!-- #post-body -->
<br class="clear" />
</div><!-- #poststuff -->

</form>

</div><!-- .wrap -->
