<?php

/**
 * Provide a screen page for import course
 *
 * This file is used to importa the json file course exported
 *
 * @link       https://decodecms.com
 * @since      1.0.0
 *
 * @package    Video_List_For_Courses
 * @subpackage Video_List_For_Courses/admin/partials
 */

    // Show messages for the user
    do_action( 'vlfc_admin_messages' );
?>

<h1><?php _e( 'Import a course', 'video-list-for-courses' ); ?></h1>

<form   method="post"
        action="<?php echo admin_url('admin-post.php'); ?>"
        enctype="multipart/form-data"
        id="vlfc-import-form-element" >

    <span><?php _e('Upload json file to import:', 'video-list-for-courses') ?></span>
    <input type="file" name="fileToUpload" id="fileToUpload">
    <br>
    <br>
    <input type="hidden" id="action" name="action" value="vlfc_import_action" />
    <input type="submit"  class="button button-primary" name="submit" value="<?php _e( 'Import Course', 'video-list-for-courses' ) ?>">
</form>