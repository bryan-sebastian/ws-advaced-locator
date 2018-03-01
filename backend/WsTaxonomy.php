<?php
if ( ! defined( 'ABSPATH' ) ) 
	exit;

if( ! class_exists( 'WsTaxonomy' ) )
{
	/**
	 * @class 		WsTaxonomy
	 * @package 	WsLocator/Backend
	 * @version  	1.0.0 Register Custom Taxonomy for Location Post Type
	 * @author  	Bryan Sebastian <bryanrsebastian@gmail.com>
	 */
	class WsTaxonomy
	{
		public function __construct()
		{
			add_action( 'init', array( $this, 'registerTaxonomy' ) );
		}

		/**
		 * Register Taxonomy
		 * 
		 * @return  void Register Taxonomy for Location Post Type
		 */
		public function registerTaxonomy()
		{
			$labels = array(
			    'name'                  => __( 'Location Categories' ),
			    'singular_name'         => __( 'Location Category' ),
			    'add_new_item'          => __( 'Add New Location Category' ),
			    'new_item_name'         => __( 'New Location Category' ),
			    'edit_item'             => __( 'Edit Location Category' ),
			    'update_item'           => __( 'Update Location Category' ),
			    'all_items'             => __( 'All Location Categories' ),
			    'search_items'          => __( 'Search Location Categories' ),
			    'parent_item'           => __( 'Parent Location Category' ),
			    'parent_item_colon'     => __( 'Parent Location Categories:' ),
			    'menu_name'             => __( 'Categories' ),
			);

			register_taxonomy( 'location-categories',
			    array( 'ws-locator' ),
			    array(
			        'hierarchical'      => true,
			        'labels'            => $labels,
			        'show_ui'           => true,
			        'show_admin_column' => true,
			        'query_var'         => true,
			    )
			);
		}
	}

	new WsTaxonomy;
}