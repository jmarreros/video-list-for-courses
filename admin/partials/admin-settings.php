  <h1><?php _e( 'Settings Video List for Courses', 'video-list-for-courses' ); ?></h1>
  <form method="post" action="options.php">

    <?php settings_fields( 'settings-video-list-for-courses' ); ?>
    <?php do_settings_sections( 'settings-video-list-for-courses' ); ?>
    
    <table class="form-table">
      <tr valign="top">
      <th scope="row"><?php _e( 'Links Youtube', 'video-list-for-courses' ); ?></th>
      <td>
        <fieldset>
          <legend class="screen-reader-text"><span><?php _e( 'Links Youtube', 'video-list-for-courses' ); ?></span></legend>

          <label for="show_link_youtube">
            <input type="checkbox" id="show_link_youtube" name="vlfc_show_link_youtube" value="1" <?php checked( '1', get_option( 'vlfc_show_link_youtube' ) ); ?>/>
            <span><?php _e( 'Show public link in course items', 'video-list-for-courses' ) ?></span>
          </label>

        </fieldset>
      </td>
      </tr>
      <tr valign="top">
      <th scope="row"><?php _e( 'Load CSS in front-end', 'video-list-for-courses' ); ?></th>
      <td>
        <fieldset>
          <legend class="screen-reader-text"><span><?php _e( 'Load CSS in front-end', 'video-list-for-courses' ); ?></span></legend>

          <label for="load_css">
            <input type="checkbox" id="load_css" name="vlfc_load_css" value="1" <?php checked( '1', get_option( 'vlfc_load_css' ) ); ?>/>
            <span><?php _e( 'Load styles file in front-end', 'video-list-for-courses' ) ?></span>
          </label>

        </fieldset>
      </td>
      </tr>
    </table>

    <?php submit_button(); ?>
  </form>