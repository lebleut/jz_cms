<?php

function jz_apply_filters( $flag, $default){
	global $jz_filters;
	$new_value = $default;
	$priorities = array();

	// Get priorities in order to sort them later
	foreach ($jz_filters as $flag_name => $flag_vector) {
		if( $flag == $flag_name ){
			foreach ($flag_vector as $priority => $filter_callbacks) {
				array_push($priorities, $priority);
			}
		}
	}
	// call function by priorities
	if( count($priorities) ){
		// sort priorities
		sort($priorities);
		foreach ($priorities as $priority) {
			foreach ($jz_filters[$flag][$priority] as $filter_callback) {
				$new_value = call_user_func($filter_callback, $new_value);
			}
		}

	}
	return $new_value;
}

function jz_add_filter( $flag, $filter_callback, $priority = 10, ...$args){
	global $jz_filters;
	
	if( !array_key_exists($flag,$jz_filters) ){
		$jz_filters[$flag] = array(
			$priority => array( $filter_callback )
		);
	}else{
		if( !array_key_exists($priority, $jz_filters[$flag]) ){
			$jz_filters[$flag][$priority] = array( $filter_callback );
		}else{
			array_push($jz_filters[$flag][$priority], $filter_callback);
		}
	}
}

function jz_do_actions($flag){
	global $jz_actions;
	$priorities = array();

	// Get priorities in order to sort them later
	foreach ($jz_actions as $flag_name => $flag_vector) {
		if( $flag == $flag_name ){
			foreach ($flag_vector as $priority => $filter_callbacks) {
				array_push($priorities, $priority);
			}
		}
	}
	// call function by priorities
	if( count($priorities) ){
		// sort priorities
		sort($priorities);
		foreach ($priorities as $priority) {
			foreach ($jz_actions[$flag][$priority] as $action_callback) {
				call_user_func($action_callback);
			}
		}
	}
}
function jz_add_action($flag, $action_callback, $priority = 10, ...$args){
	global $jz_actions;

	if( !array_key_exists($flag,$jz_actions) ){
		$jz_actions[$flag] = array(
			$priority => array( $action_callback )
		);
	}else{
		if( !array_key_exists($priority, $jz_actions[$flag]) ){
			$jz_actions[$flag][$priority] = array( $action_callback );
		}else{
			array_push($jz_actions[$flag][$priority], $action_callback);
		}
	}
}