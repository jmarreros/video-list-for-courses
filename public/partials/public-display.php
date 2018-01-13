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
?>


<div class="vlfc-container">
	<div class="vlfc-list">
		<?php vlfc_list_content( $course ); ?>
	</div>
	<div class="vlfc-detail">
		<div class="vlfc-video"></div>
		<div class="vlfc-notes"></div>
	</div>
</div>

<?php

function vlfc_list_content( $course ){
	$content = json_decode($course->content());
	$str = '';
	$flag_header = false;

	if ( count($content)  > 0 ):
		echo "<ul class='course-list-items' data-id='".$course->id()."'>\n";
		

		foreach ($content as $index => $item) {
			
			if ( $item->isheader ){
				$str .= "<li class='section'>\n";
				$str .= vlfc_create_link($item, true);
				$flag_header = true;	

			} else {
				$str .= vlfc_create_link($item , $flag_header);
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


function vlfc_create_link ( $item, $flag_header ) {

	$name = $item->name;
	$isheader = $item->isheader;
	$islock = $item->islock;
	$duration = $item->duration;

	$str = '';

	if ( $duration ) $duration = "<span>(".$duration.")</span>";
	
	if ( $isheader ){
		$str =  sprintf("<div>%s</div>\n", $name);
	} elseif ($islock) {
		$str = sprintf("<a href='#' class='islock'>%s %s</a>\n", $name, $duration );
	} else{
		$str = sprintf("<a href='#' class='islink'>%s %s</a>\n", $name, $duration );
	}
	
	if ( ! $flag_header ) {
		$str = "<li>".$str."</li>\n";
	}

	return $str;
}
?>
 