<?php
if ( ! defined( 'ABSPATH' ) ) 
	exit;

if( ! class_exists( 'WsPostType' ) )
{
	/**
	 * @class 		WsPostType
	 * @package 	WsLocator/Backend
	 * @version  	1.0.0 Register Custom Posttype and add custom meta Box
	 * @author  	Bryan Sebastian <bryanrsebastian@gmail.com>
	 */
	class WsPostType
	{
		public function __construct()
		{
			add_action( 'init', array( $this, 'registerPostType' ) );
			add_action( 'add_meta_boxes', array( $this, 'addMetaBox' ) );
			add_action( 'save_post', array( $this, 'saveMetaBoxContentValue' ) );
		}

		/**
		 * Register Post Type
		 * @return void Register Post Type Location
		 */
		public function registerPostType()
		{
			$labels = array(
				'name' 				 => __( 'Location' ),
				'singular_name' 	 => __( 'Location' ),
				'add_new' 			 => __( 'Add New' ),
				'add_new_item' 		 => __( 'Add New Location' ),
				'edit_item' 		 => __( 'Edit Location' ),
				'new_item' 			 => __( 'New Location' ),
				'all_items' 		 => __( 'All Location' ),
				'view_item' 		 => __( 'View Location' ),
				'search_items' 		 => __( 'Search Location' ),
				'not_found' 		 => __( 'No Location Found' ),
				'not_found_in_trash' => __( 'No Location Found in Trash' ), 
				'parent_item_colon'	 => '',
				'menu_name' 		 => __( 'Location' )
			);

			$args = array(
				'labels' 			 => $labels,
				'public' 			 => true,
				'publicly_queryable' => true,
				'show_ui' 			 => true, 
				'show_in_menu' 		 => true, 
				'query_var' 		 => true,
				'rewrite' 			 => true,
				'capability_type' 	 => 'post',
				'has_archive' 		 => true, 
				'hierarchical' 		 => false,
				'supports' 			 => array( 'title', 'editor' ),
				'menu_icon'   		 => 'dashicons-location-alt',
			); 

			register_post_type( 'ws-locator', $args );
		}

		/**
		 * Add meta box in specific post type
		 * @param string $post_type specific post type
		 */
		public function addMetaBox( $post_type )
		{
			// Limit meta box to certain post types.
	        $post_types = array( 'ws-locator' );

	        if ( in_array( $post_type, $post_types ) ) 
	        {
	            add_meta_box(
	                'location_details',
	                __( 'Location Details' ),
	                array( $this, 'renderMetaBoxContent' ),
	                $post_type,
	                'normal',
	                'high'
	            );
	        }
		}

		/**
	     * Render Meta Box content.
	     * @param WP_Post $post The post object.
	     */
		public function renderMetaBoxContent( $post )
		{
			// Add an nonce field so we can check for it later.
	        wp_nonce_field( 'ws_locator', 'ws_locator_nonce' );
	 
	        // Use get_post_meta to retrieve an existing value from the database.
	        $location_long = get_post_meta( $post->ID, '_location_long', true );
	        $location_lat = get_post_meta( $post->ID, '_location_lat', true );
	        $location_details = get_post_meta( $post->ID, '_location_details', true );

	        // Display the form, using the current value.
	        include_once 'partials/metaboxContent.php';
		}

		/**
	     * Save the meta when the post is saved.
	     * @param int $post_id The ID of the post being saved.
	     */
		public function saveMetaBoxContentValue( $post_id )
		{
			/*
	         * We need to verify this came from the our screen and with proper authorization,
	         * because save_post can be triggered at other times.
	         */
	 
	        // Check if our nonce is set.
	        if ( ! isset( $_POST['ws_locator_nonce'] ) ) {
	            return $post_id;
	        }
	 
	        $nonce = $_POST['ws_locator_nonce'];
	 
	        // Verify that the nonce is valid.
	        if ( ! wp_verify_nonce( $nonce, 'ws_locator' ) ) {
	            return $post_id;
	        }
	 
	        /*
	         * If this is an autosave, our form has not been submitted,
	         * so we don't want to do anything.
	         */
	        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
	            return $post_id;
	        }
	 
	        // Check the user's permissions.
	        if ( 'ws-locator' == $_POST['post_type'] ) {
	            if ( ! current_user_can( 'edit_page', $post_id ) ) {
	                return $post_id;
	            }
	        } else {
	            if ( ! current_user_can( 'edit_post', $post_id ) ) {
	                return $post_id;
	            }
	        }
	 
	        /* OK, it's safe for us to save the data now. */
	 
	        // Sanitize the user input.
	        $location_long = sanitize_text_field( $_POST['location_long'] );
	        $location_lat = sanitize_text_field( $_POST['location_lat'] );
	        $location_details = $_POST['location_details'];

	        // Update the meta field.
	        update_post_meta( $post_id, '_location_long', $location_long );
	        update_post_meta( $post_id, '_location_lat', $location_lat );
	        update_post_meta( $post_id, '_location_details', $location_details );
		}
	}

	new WsPostType;
}