<?php

//Get the "option" var from the url
function vlfc_current_option() {
	if ( isset( $_REQUEST['option'] ) && -1 != $_REQUEST['option'] ) {
		return $_REQUEST['option'];
	}
	else if ( isset( $_REQUEST['page'] ) && $_REQUEST['page'] == 'vlfc-new' ){
		return 'new';
	}
	
	return false;
}

//Get the "post" var from de url
function vlfc_current_post(){

	if ( isset( $_REQUEST['course_id']  ) ){
		return absint($_REQUEST['course_id']);
	}
	else if ( isset( $_REQUEST['post']  ) ){
		return absint($_REQUEST['post']);
	}

	return false;
}

// Validate for loading scripts css and js in admin area
function is_page_vlfc(){

	if ( isset($_REQUEST['page']) ){
		$page = $_REQUEST['page'];
		return ($page == 'vlfc' || $page == 'vlfc-new');	
	}
	return false;

}


