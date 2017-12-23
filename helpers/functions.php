<?php

function vlfc_current_action() {
	if ( isset( $_REQUEST['action'] ) && -1 != $_REQUEST['action'] ) {
		return $_REQUEST['action'];
	}
	return false;
}
