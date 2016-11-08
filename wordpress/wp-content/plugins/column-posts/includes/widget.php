<?php

/**
 * Login form widgetclass.
 *
 * @package column-posts
 * @subpackage Widget
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/*
 * ColumnPost_Widget Class
 */
class ColumnPost_Widget extends WP_Widget {

	function register_widget() {
		register_widget( 'ColumnPost_Widget' );
	}

	function ColumnPost_Widget() {
		$widget_ops = array( 'description' => __( "Display category or posts in columns") );
		$this->WP_Widget('Column Posts', __('Column Posts'), $widget_ops);
	}

	function widget( $args, $instance ) {
		global $columnpost;

		$columnpost->cp_frontend();	
	}

	function update( $new_instance, $old_instance ){
		$instance['title'] = strip_tags(stripslashes($new_instance['title']));
		return $instance;
	}

	function form( $instance ){
		echo '<p>' .sprintf(__('To set up options, please go to the <a href="%s">settings</a>','cp'),'options-general.php?page=column-posts') .'</p>';	
	}
}
?>
