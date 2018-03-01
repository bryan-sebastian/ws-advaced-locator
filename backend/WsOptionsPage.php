<?php
if ( ! defined( 'ABSPATH' ) ) 
	exit;

if( ! class_exists( 'WsOptionPage' ) )
{
    /**
     * @class       WsOptionPage
     * @package     WsLocator/Backend
     * @version     1.0.0 Create Options page and their field
     * @author      Bryan Sebastian <bryanrsebastian@gmail.com>
     */
    class WsOptionPage
    {
        public function __construct()
        {
            add_action( 'admin_menu', array( $this, 'addMenuPage' ) );
            add_action( 'admin_init', array( $this, 'optionDescription' ) );
            $this->_includeBackendExtension();
        }

        /**
         * Include files
         * @return void include some files to generate fields in this option page
         */
        private function _includeBackendExtension()
        {
            include_once 'WsOptionsPageFields.php';
        }

        /**
    	 * Add menu and options page
        * @return void
    	 */
    	public function addMenuPage()
    	{
    		add_menu_page( 
    			'WS Advanced Locator Settings',
    			'WSAL Settings',
    			'manage_options',
    			'ws-locator-settings',
    			array( $this, 'createWsOptionPage' ),
    			'dashicons-location',
    			100
    		);
    	}

        /**
         * Options page callback
         * @return  void include the form
         */
        public function createWsOptionPage()
        {
            include_once 'partials/form.php';
        }

        /**
         * Add Option Description Section
         * @return void create option description section
         */
        public function optionDescription()
        {
            add_settings_section(
                'setting_section_id', // ID
                'WS Advanced Locator', // Title
                array( $this, 'optionCallback' ), // Callback
                'ws-locator-settings' // Page
            );

            add_settings_section(
                'ws_locator_setting_id', // ID
                'Location & Map Settings', // Title
                array( $this, 'locationMapDescriptionCallback' ), // Callback
                'ws-locator-location-map-settings' // Page
            );
        }

        /**
         * Call back for setting_section_general_id field
         * @return void generate information
         */
        public function optionCallback()
        {
            include_once 'partials/instruction.php';
        }

        /**
         * Call back for setting_section_location_map_id field
         * @return string generate information
         */
        public function locationMapDescriptionCallback()
        {
            print 'Enter your location and map settings below:';
        }
    }

    new WsOptionPage();
}