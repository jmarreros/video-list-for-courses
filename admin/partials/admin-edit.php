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
	$course_id = $course->id();
?></h1>

<hr class="wp-header-end">



<form method="post" 
	action="<?php echo esc_url( add_query_arg( array( 'post' => $course_id ), menu_page_url( 'vlfc', false ) ) ); ?>" 
	id="wpcf7-admin-form-element" >


<input type="hidden" id="post_ID" name="post_ID" value="<?php echo (int) $course_id; ?>" />
<input type="hidden" id="hiddenaction" name="action" value="save" />


<div id="poststuff">
<div id="post-body" class="metabox-holder columns-2">
<div id="post-body-content">
<div id="titlediv">
<div id="titlewrap">
<label class="screen-reader-text" id="title-prompt-text" for="title">
	<?php echo esc_html( __( 'Enter title here', 'video-list-for-courses' ) ); ?>
</label>
<input 
	name="post_title" 
	size="30" 
	value="<?php echo $course->initial() ? '' : $course->title(); ?>" 
	id="title" 
	spellcheck="true" 
	autocomplete="off" 
	type="text">
</div><!-- #titlewrap -->

<div class="inside">
	<?php //Para colocar le shortcode cuando es una edición ?>
</div><!-- inside -->

</div><!-- #titlediv -->

<div id="wp-content-editor-container" class="wp-editor-container">
	<textarea class="wp-editor-area" 
			autocomplete="off" 
			cols="40" 
			name="content" 
			id="content"><?php echo $course->initial() ? '' : $course->content(); ?></textarea>
</div><!-- wp-content-editor-container -->

</div><!-- #post-body-content -->


<div id="postbox-container-1" class="postbox-container">

	<div id="submitdiv" class="postbox">
	<h3><?php echo esc_html( __( 'Status', 'video-list-for-courses' ) ); ?></h3>

	<div class="inside">
	<div class="submitbox" id="submitpost">

<!-- 		<div class="hidden">
			<input type="submit" 
					class="button-primary" 
					name="vlfc-save" 
					value="<?php echo esc_attr( __( 'Save', 'video-list-for-courses' ) ); ?>" />
		</div> -->

		<div id="minor-publishing-actions"> 			
		
			<div id="duplicate-action">
			<?php
				if ( ! $course->initial() ) :
					$copy_nonce = wp_create_nonce( 'vlfc-copy-course_' . $course_id );
			?>
				<input type="submit" 
						name="vlfc-copy" 
						class="copy button" 
						value="<?php echo esc_attr( __( 'Duplicate', 'video-list-for-courses' ) ); ?>" 
						<?php echo "onclick=\"this.form._wpnonce.value = '$copy_nonce'; this.form.action.value = 'copy'; return true;\""; ?> />
			<?php endif; ?>
			</div><!-- #duplicate-action -->

		</div><!-- #minor-publishing-actions -->

		<div id="major-publishing-actions">
			<?php
				if ( ! $course->initial() ) :
					$delete_nonce = wp_create_nonce( 'vlfc-delete-course_' . $course_id );
			?>
			<div id="delete-action">
				<input type="submit" 
						name="vlfc-delete" 
						class="delete submitdelete" 
						value="<?php echo esc_attr( __( 'Delete', 'video-list-for-courses' ) ); ?>" 
						<?php echo "onclick=\"if (confirm('" . esc_js( __( "You are about to delete this course.\n  'Cancel' to stop, 'OK' to delete.", 'video-list-for-courses' ) ) . "')) {this.form._wpnonce.value = '$delete_nonce'; this.form.action.value = 'delete'; return true;} return false;\""; ?> />
			</div><!-- #delete-action -->
			<?php endif; ?>

			<div id="publishing-action">
				<span class="spinner"></span>
				<?php 
					$save_nonce = wp_create_nonce( 'vlfc-save-course_' . $course_id );
					$onclick = sprintf(
								"this.form._wpnonce.value = '%s';"
								. " this.form.action.value = 'save';"
								. " return true;",
								$save_nonce );
				?>
				<input type="submit" 
						class="button-primary" 
						name="vlfc-save" 
						value="<?php echo esc_attr( __( 'Save', 'video-list-for-courses' )) ?>"
						onclick="<?php echo $onclick ?>" />
			</div><!-- #publishing-action -->
			<div class="clear"></div>


		</div><!-- #major-publishing-actions -->

	</div><!-- #submitpost -->
	</div><!-- inside -->

	</div><!-- #submitdiv -->


</div><!-- #postbox-container-1 -->

</div><!-- #post-body -->
<br class="clear" />
</div><!-- #poststuff -->

</form>

</div><!-- .wrap -->
