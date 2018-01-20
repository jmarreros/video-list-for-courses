<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://decodecms.com
 * @since      1.0.0
 *
 * @package    Video_List_For_Courses
 * @subpackage Video_List_For_Courses/public/partials
 */

require_once VLFC_DIR . 'helpers/functions.php';
?>


<div class="vlfc-container">
	<div class="vlfc-list">
		<?php vlfc_list_content( $course ); ?>
	</div>
	<div class="vlfc-detail">
		<div class="vlfc-name"></div>
		<div class="vlfc-video"></div>
		<div class="vlfc-notes"></div>
		<div class="vlfc-footer">
			<a id="prev" href="#"><?php _e('Previous', 'video-list-for-courses') ?></a>
			<a id="next" href="#"><?php _e('Next', 'video-list-for-courses') ?></a>
		</div>
	</div>
</div>

<?php


//Function for creating the list content
function vlfc_list_content( $course ){
	$content = json_decode($course->content());
	$str = '';
	$flag_header = false;
	$count_links = 0;

	if ( count($content)  > 0 ):
		echo "<ul class='course-list-items' data-id='".$course->id()."'>\n";
		

		foreach ($content as $index => $item) {
			
			if ( $item->isheader ){
				$str .= "<li class='section'>\n";
				$str .= vlfc_create_link($item, true);
				$flag_header = true;
			} else {
				$count_links++;
				$str .= vlfc_create_link($item, $flag_header, $count_links);
			}

			if ( $flag_header && count($content) > $index + 1 ){
				if ( $content[$index + 1 ]->isheader ){
					$str .= "</li>\n";
					$flag_header = false;
				}
			}

		} // for each

		if ( $flag_header ){
			$str .= "</li>\n";
		}
			
		echo $str;
		echo "</ul>\n";
	endif;
}

// Create each link
function vlfc_create_link ( $item, $flag_header, $count_links = 0 ) {
	$id_item = $item->id_item; 
	$name = $item->name;
	$isheader = $item->isheader;
	$islock = $item->islock;
	$class = 'islink';
	$url = '#';	
	$duration = '';
	$iconlock = '';
	$str = '';

	$option = get_option('vlfc_options');

	if ( isset($option['link_youtube']) ) $url = get_url_youtube($item->code);
	if ( isset($option['video_duration']) && $item->duration ) $duration = "<span>(".$item->duration.")</span>";
	if ( isset($option['number_items']) && ! $isheader ) $name = $count_links . '- ' . $name;
	if ( isset($option['lock_icon']) && ! is_user_logged_in() ) $iconlock = '🔒';

	if ( $isheader ){
		$str =  sprintf("<div>%s</div>\n", $name);
	} elseif ($islock) {
		if ( ! is_user_logged_in() ) {
			$class = 'islock';
			$url = '#';
		}
		$str = sprintf("<a data-id='%d' href='%s' class='%s'>%s %s %s</a>\n", $id_item, $url, $class, $iconlock, $name, $duration );
	} else{
		$str = sprintf("<a data-id='%d' href='%s' class='%s'>%s %s</a>\n", $id_item, $url, $class, $name, $duration );
	}
	
	if ( ! $flag_header ) {
		$str = "<li>".$str."</li>\n";
	}

	return $str;
}


?>
 