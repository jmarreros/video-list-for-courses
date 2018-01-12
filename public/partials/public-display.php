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

	if ( count($content)  > 0 ):
		echo "<ul class='course-list-items' data-id='".$course->id()."'>";
		foreach ($content as $item) {
			echo "<li data-id=".$item->id_item." class='course-item'>".
					vlfc_create_link( $item->name, $item->isheader, $item->islock, $item->duration )
				 ."</li>";
		}
		echo "</ul>";
	endif;
}


function vlfc_create_link( $name, $isheader, $islock, $duration ){
	$str = '';

	if ( $isheader ){
		return sprintf('<span class="isheader">%s</span>', $name);
	}
	if ( $islock ){
		return sprintf('<a href="#" class="islock">%s</a>', $name);
	}

	return sprintf('<a href="#" class="islink">%s %s</a>', $name, $duration );
}
?>
 