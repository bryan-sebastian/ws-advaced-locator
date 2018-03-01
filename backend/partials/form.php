<div id="ws-locator" class="wrap">
    <form method="post" action="options.php">
    	<?php
    		do_settings_sections( 'ws-locator-settings' );

            settings_fields( 'ws_locator_group' );
            do_settings_sections( 'ws-locator-location-map-settings' );

            submit_button();
    	?>
    </form>
    <div id="donation-box">
    	<a href="https://www.paypal.me/bryanrsebastian" target="_blank" style="box-shadow: 0 0 0; -webkit-box-shadow: 0 0 0;">
	    	<img src="<?php echo plugin_dir_url( __FILE__ ) ?>../imgs/buy-me-a-coffee.png" style="width: 200px">
    	</a>
    </div>
</div>