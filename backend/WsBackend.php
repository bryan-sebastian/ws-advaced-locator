<?php
if ( ! defined( 'ABSPATH' ) ) 
	exit;

if( ! class_exists( 'WsBackend' ) )
{
	/**
	 * @class 		WsBackend
	 * @package 	WsLocator/Backend
	 * @version  	1.0.0 Initialize Backend Process
	 * @author  	Bryan Sebastian <bryanrsebastian@gmail.com>
	 */
	class WsBackend
	{
		private $_options;

		public function __construct()
		{
			$this->_options = get_option( 'ws_locator' );

			if( isset( $_GET['page'] ) ) {
				if( $_GET['page'] == 'ws-locator-settings' )
					add_action( 'init', 'wp_enqueue_media' );
			}
			
			add_action( 'admin_enqueue_scripts', array( $this, 'includeAssets' ) );

			if ( isset( $_GET['page'] ) && $_GET['page'] == 'ws-locator-settings' ) {
				if( isset( $this->_options['map_api_key'] ) && $this->_options['map_api_key'] == '' )
					add_action( 'admin_notices', array( $this, 'noAPIKeySet' ) );

				if ( isset( $this->_options['status'] ) && $this->_options['status'] == 1 ) {
					add_action( 'admin_notices', array( $this, 'updateNotice' ) );
					$this->_options['status'] = 0;
					update_option( 'ws_locator', $this->_options );
				}
			}

			$this->_includeBackendExtension();
		}

		/**
		 * Admin notice if no googlemap api key is set.
		 */
		public function noAPIKeySet() 
		{
		    include_once 'partials/noticeForAPIKey.php';
		}

		/**
		 * Admin notice if the settings is updated.
		 */
		public function updateNotice() 
		{
		    include_once 'partials/updateNotice.php';
		}

		/**
		 * Include CSS and JS
		 * @return void
		 */
		public function includeAssets()
		{
			wp_enqueue_style( 'backend-style', plugin_dir_url( __FILE__ ) .'/css/backend.css');

			wp_register_script( 'backend-js', plugin_dir_url( __FILE__ ) .'/js/backend.js', array('jquery'), NULL, true );
			wp_enqueue_script( 'backend-js' );
		}

		/**
		 * Include PHP file
		 * @return void
		 */
		private function _includeBackendExtension()
		{
			include_once 'WsOptionsPage.php';
			include_once 'WsPostType.php';
			include_once 'WsTaxonomy.php';
		}
	}

	new WsBackend;
}