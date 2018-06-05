<?php
/* Template Name: Jamel CMS */

/* FUNCTIONS */
	function get_path(){
		return( __DIR__ );
	}

	include get_path().'/config.php';
	include get_path().'/functions/hooks.php';

	function jz_header(){
		include get_path().'/header.php';
	}

	function jz_footer(){
		include get_path().'/footer.php';
	}
	function jz_title($default_title){
		$title = jz_apply_filters("the_title", $default_title);
		echo( $title );
	}

/* END -FUNCTIONS */

/* ALTERS HERE */
	jz_add_filter('footer_text','alter_footer_text');
	jz_add_filter('footer_text','alter_footer_text_2', 20);
	jz_add_action('after_section', 'after_section_cb');

	function alter_footer_text($default_msg){
		return $default_msg.' alter [1]';
	}

	function alter_footer_text_2($default_msg){
		return $default_msg.' alter [2]';
	}

	function after_section_cb(){
		global $jz_filters, $jz_actions;

		echo '<pre>';
		print_r($jz_filters);
		print_r($jz_actions);
		echo '</pre>';
	}
/* end - ALTERS */

/* RUN TEMPLATE */
include get_path().'/page.php';