<?php
if ( ! defined( 'ABSPATH' ) ) 
	exit;

if( ! class_exists( 'WsOptionsPageFields' ) )
{
    /**
     * @class       WsOptionsPageFields
     * @package     WsLocator/Backend
     * @version     1.0.0 Generate Option Page Fields
     * @author      Bryan Sebastian <bryanrsebastian@gmail.com>
     */
    class WsOptionsPageFields
    {
        private $_options;

        public function __construct()
        {
            $this->_options = get_option( 'ws_locator' );
            add_action( 'admin_init', array( $this, 'optionFieldsGroup' ) );
            add_action( 'admin_init', array( $this, 'optionFields' ) );
        }

        /**
         * Register and add settings
         * @return  void
         */
        public function optionFieldsGroup()
        {        
            register_setting(
                'ws_locator_group', // Option group
                'ws_locator' // Option name
            );
        }

        /**
         * Add Option fields
         * @return  void
         */
        public function optionFields()
        {   
            $settings = array(
                array(
                    'setting_name'      => 'location_categories',
                    'setting_title'     => 'Categories',
                    'setting_callback'  => 'locationCategoriesCallback'
                ),
                array(
                    'setting_name'      => 'location_search',
                    'setting_title'     => 'Search',
                    'setting_callback'  => 'locationSearchCallback'
                ),
                array(
                    'setting_name'      => 'map_api_key',
                    'setting_title'     => 'Google Map API Key <span style="color: red;">*</span>',
                    'setting_callback'  => 'mapAPIKeyCallback'
                ),
                array(
                    'setting_name'      => 'map_center_longitude',
                    'setting_title'     => 'Center Longitude',
                    'setting_callback'  => 'mapCenterLongitudeCallback'
                ),
                array(
                    'setting_name'      => 'map_center_latitude',
                    'setting_title'     => 'Center Latitude',
                    'setting_callback'  => 'mapCenterLatitudeCallback'
                ),
                array(
                    'setting_name'      => 'map_zoom_level',
                    'setting_title'     => 'Zoom Level',
                    'setting_callback'  => 'mapZoomLevelCallback'
                ),
                array(
                    'setting_name'      => 'map_height',
                    'setting_title'     => 'Map Height (px)',
                    'setting_callback'  => 'mapHeightCallback'
                ),
                array(
                    'setting_name'      => 'google_map_marker',
                    'setting_title'     => 'Marker',
                    'setting_callback'  => 'googleMapMarkerCallback'
                ),
                array(
                    'setting_name'      => 'google_map_theme',
                    'setting_title'     => 'Theme',
                    'setting_callback'  => 'googleMapThemeCallback'
                ),
                array(
                    'setting_name'      => 'google_map_draggable',
                    'setting_title'     => 'Draggable',
                    'setting_callback'  => 'googleMapDraggableCallback'
                ),
                array(
                    'setting_name'      => 'google_map_doubleclickzoom',
                    'setting_title'     => 'Double Click Zoom',
                    'setting_callback'  => 'googleMapDoubleClickZoomCallback'
                ),
                array(
                    'setting_name'      => 'google_map_zoomcontrol',
                    'setting_title'     => 'Zoom Control',
                    'setting_callback'  => 'googleMapZoomControlCallback'
                ),
                array(
                    'setting_name'      => 'google_map_scrollwheel',
                    'setting_title'     => 'Scroll Wheel',
                    'setting_callback'  => 'googleMapScrollWheelCallback'
                ),
                array(
                    'setting_name'      => 'google_map_streetview',
                    'setting_title'     => 'Street View',
                    'setting_callback'  => 'googleMapStreetViewCallback'
                ),
                array(
                    'setting_name'      => 'status',
                    'setting_title'     => '',
                    'setting_callback'  => 'statusCallback'
                ),
            );

            foreach ( $settings as $setting ) {
                add_settings_field(
                    $setting['setting_name'], 
                    $setting['setting_title'], 
                    array( $this, $setting['setting_callback'] ),
                    'ws-locator-location-map-settings', 
                    'ws_locator_setting_id'
                );
            }
        }

        /**
         * Call back for location_categories field
         * @return void generate input type checkbox and their value
         */
        public function locationCategoriesCallback()
        {
            printf(
                '<input type="checkbox" id="location_categories" name="ws_locator[location_categories]" %s><label for="location_categories"><i>Show list of categories to filter the location.</i></label>',
                isset( $this->_options['location_categories'] ) ? 'checked' : ''
            );
        }

        /**
         * Call back for location_search field
         * @return void generate input type checkbox and their value
         */
        public function locationSearchCallback()
        {
            printf(
                '<input type="checkbox" id="location_search" name="ws_locator[location_search]" %s><label for="location_search"><i>Show the search bar in location list.</i></label>',
                isset( $this->_options['location_search'] ) ? 'checked' : ''
            );
        }

        /**
         * Call back for map_api_key field
         * @return void generate input type text and their value
         */
        public function mapAPIKeyCallback()
        {
            printf(
                '
                    <input type="text" id="map_api_key" name="ws_locator[map_api_key]" value="%s"/>
                    <p>
                        <i>
                        WS Advanced Locator required to get API key at <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">Google Map API Key</a>.
                        </i>
                    </p>
                ',
                isset( $this->_options['map_api_key'] ) ? esc_attr( $this->_options['map_api_key'] ) : ''
            );
        }

        /**
         * Call back for map_center_longitude field
         * @return void generate input type text and their value
         */
        public function mapCenterLongitudeCallback()
        {
            printf(
                '
                    <input type="text" id="map_center_longitude" name="ws_locator[map_center_longitude]" value="%s" />
                    <p><i>Default longitude is <strong>14.617178</strong> Manila, Philippines Longitude.</i></p>
                ',
                isset( $this->_options['map_center_longitude'] ) ? esc_attr( $this->_options['map_center_longitude'] ) : ''
            );
        }

        /**
         * Call back for map_center_latitude field
         * @return void generate input type text and their value
         */
        public function mapCenterLatitudeCallback()
        {
            printf(
                '
                    <input type="text" id="map_center_latitude" name="ws_locator[map_center_latitude]" value="%s" />
                    <p><i>Default latitude is <strong>120.974644</strong> Manila, Philippines Latitude.</i></p>
                ',
                isset( $this->_options['map_center_latitude'] ) ? esc_attr( $this->_options['map_center_latitude'] ) : ''
            );
        }

        /**
         * Call back for map_zoom_level field
         * @return void generate input type number and their value
         */
        public function mapZoomLevelCallback()
        {
            printf(
                '
                    <input type="number" id="map_zoom_level" name="ws_locator[map_zoom_level]" value="%s" />
                    <p><i>Default zoom level is <strong>4</strong>.</i></p>
                ',
                isset( $this->_options['map_zoom_level'] ) ? esc_attr( $this->_options['map_zoom_level'] ) : ''
            );
        }

        /**
         * Call back for map_height field
         * @return void generate input type number and their value
         */
        public function mapHeightCallback()
        {
            printf(
                '
                    <input type="number" id="map_height" name="ws_locator[map_height]" value="%s" />
                    <p><i>Set map height to initialize it. Default height is <strong>200px</strong></i></p>
                ',
                isset( $this->_options['map_height'] ) ? esc_attr( $this->_options['map_height'] ) : ''
            );
        }

        /**
         * Call back for google_map_marker field
         * @return void generate input type file and their value
         */
        public function googleMapMarkerCallback()
        {
            ?>
                <div id="select-image-container">
                    <div class="action-image-upload">
                        <a id="select-image">SELECT IMAGE</a>
                        <a id="remove-image">REMOVE IMAGE</a>
                    </div>
                    <img src="<?php echo isset( $this->_options['google_map_marker'] ) ? esc_attr( $this->_options['google_map_marker'] ) : '' ?>">
                    <input 
                        type="hidden" 
                        name="ws_locator[google_map_marker]" 
                        value="<?php echo isset( $this->_options['google_map_marker'] ) ? esc_attr( $this->_options['google_map_marker'] ) : '' ?>"
                    />
                </div>
            <?php
        }

        /**
         * Call back for google_map_theme field
         * @return void generate textarea and their value
         */
        public function googleMapThemeCallback()
        {
            printf(
                '
                    <textarea id="google_map_theme" name="ws_locator[google_map_theme]" rows="15">%s</textarea>
                    <p><i>You can get a theme at <a href="https://snazzymaps.com/">Snazzy Maps</a><i>.</p>
                ',
                isset( $this->_options['google_map_theme'] ) ? esc_attr( $this->_options['google_map_theme'] ) : ''
            );
        }

        /**
         * Call back for google_map_draggable field
         * @return void generate input type checkbox and their value
         */
        public function googleMapDraggableCallback()
        {
            printf(
                '<input type="checkbox" id="google_map_draggable" name="ws_locator[google_map_draggable]" %s><label for="google_map_draggable"><i>Disable the draggble function of the map.</i></label>',
                isset( $this->_options['google_map_draggable'] ) ? 'checked' : ''
            );
        }

        /**
         * Call back for google_map_doubleclickzoom field
         * @return void generate input type checkbox and their value
         */
        public function googleMapDoubleClickZoomCallback()
        {
            printf(
                '<input type="checkbox" id="google_map_doubleclickzoom" name="ws_locator[google_map_doubleclickzoom]" %s><label for="google_map_doubleclickzoom"><i>Enables double click zoom.</i></label>',
                isset( $this->_options['google_map_doubleclickzoom'] ) ? 'checked' : ''
            );
        }

        /**
         * Call back for google_map_zoomcontrol field
         * @return void generate input type checkbox and their value
         */
        public function googleMapZoomControlCallback()
        {
            printf(
                '<input type="checkbox" id="google_map_zoomcontrol" name="ws_locator[google_map_zoomcontrol]" %s><label for="google_map_zoomcontrol"><i>Disable zoom control.</i></label>',
                isset( $this->_options['google_map_zoomcontrol'] ) ? 'checked' : ''
            );
        }

        /**
         * Call back for google_map_scrollwheel field
         * @return void generate input type checkbox and their value
         */
        public function googleMapScrollWheelCallback()
        {
            printf(
                '<input type="checkbox" id="google_map_scrollwheel" name="ws_locator[google_map_scrollwheel]" %s><label for="google_map_scrollwheel"><i>Disable scrollwheel for zooming on the map.</i></label>',
                isset( $this->_options['google_map_scrollwheel'] ) ? 'checked' : ''
            );
        }

        /**
         * Call back for google_map_streetview field
         * @return void generate input type checkbox and their value
         */
        public function googleMapStreetViewCallback()
        {
            printf(
                '<input type="checkbox" id="google_map_streetview" name="ws_locator[google_map_streetview]" %s><label for="google_map_streetview"><i>Disable street view.</i></label>',
                isset( $this->_options['google_map_streetview'] ) ? 'checked' : ''
            );
        }

        /**
         * Call back for statusCallback field
         * @return void generate input type hidden and their value
         */
        public function statusCallback()
        {
            echo '<input type="hidden" id="status" name="ws_locator[status]" value="1">';
        }
    }

    new WsOptionsPageFields;
}