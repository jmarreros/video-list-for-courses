<?php

//Get the "option" var from the url
function vlfc_current_option() {
	if ( isset( $_REQUEST['option'] ) && -1 != $_REQUEST['option'] ) {
		return $_REQUEST['option'];
	} elseif ( isset( $_REQUEST['page'] ) && $_REQUEST['page'] == 'vlfc-new' ){
		return 'new';
	}
	// elseif ( isset( $_REQUEST['page'] ) && $_REQUEST['page'] == 'vlfc-settings' ){
	// 	return 'settings';
	// }

	
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

// Get current bulk action
function current_bulk_action() {
    if ( isset( $_REQUEST['filter_action'] ) && ! empty( $_REQUEST['filter_action'] ) )
        return false;
 
    if ( isset( $_REQUEST['action'] ) && -1 != $_REQUEST['action'] )
        return $_REQUEST['action'];
 
    if ( isset( $_REQUEST['action2'] ) && -1 != $_REQUEST['action2'] )
        return $_REQUEST['action2'];
 
    return false;
}




