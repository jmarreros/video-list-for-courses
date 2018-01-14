  <h1><?php _e( 'Settings Video List for Courses', 'video-list-for-courses' ); ?></h1>
  <form method="post" action="options.php">

    <?php settings_fields( 'settings-video-list-for-courses' ); ?>
    <?php do_settings_sections( 'settings-video-list-for-courses' ); ?>
    
    <?php $vlfc_options = get_option('vlfc_options'); ?>

    <table class="form-table">

      <?php 

        // Number in items
        $title =  __( 'Number in items', 'video-list-for-courses' );
        $subtitle = __( 'show numbers sequence links', 'video-list-for-courses' );
        $key = 'number_items';

        create_checkbox_setting_row( $title, $subtitle, $key, $vlfc_options);

        // Video duration
        $title =  __( 'Video duration', 'video-list-for-courses' );
        $subtitle = __( 'show video duration next the item name', 'video-list-for-courses' );
        $key = 'video_duration';

        create_checkbox_setting_row( $title, $subtitle, $key, $vlfc_options);

        // Link youtube
        $title =  __( 'Links Youtube', 'video-list-for-courses' );
        $subtitle = __( 'Show public link in href attribute course items', 'video-list-for-courses' );
        $key = 'link_youtube';

        create_checkbox_setting_row( $title, $subtitle, $key, $vlfc_options);

        // Load CSS
        $title =  __( 'Load CSS in front-end', 'video-list-for-courses' );
        $subtitle = __( 'Load styles file in front-end', 'video-list-for-courses' );
        $key = 'load_css';

        create_checkbox_setting_row( $title, $subtitle, $key, $vlfc_options);

        // Show Lock icon
        $title =  __( 'Lock icon', 'video-list-for-courses' );
        $subtitle = __( 'show unicode lock char in lock items', 'video-list-for-courses' );
        $key = 'lock_icon';

        create_checkbox_setting_row( $title, $subtitle, $key, $vlfc_options);

      ?>

    </table>

    <?php submit_button(); ?>
  </form>


  <?php

  function create_checkbox_setting_row( $title, $subtitle, $key, $vlfc_options){

      echo ' 
      <tr valign="top">
      <th scope="row">'.$title.'</th>
      <td>
        <fieldset>
          <legend class="screen-reader-text"><span>'.$title .'</span></legend>
          <label for="'.$key.'">
            <input type="checkbox" id="'.$key.'" name="vlfc_options['.$key.']" '. checked( isset($vlfc_options[$key]), true, false ) .'/>
            <span>'.$subtitle.'</span>
          </label>

        </fieldset>
      </td>
      </tr>';

  }

  