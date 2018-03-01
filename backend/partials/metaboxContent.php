<table id="ws-locator-table">
	<tbody>
		<tr>
			<td><?php _e( 'Location Longitude' ); ?></td>
			<td><input type="text" id="location_long" name="location_long" value="<?php esc_attr_e( $location_long ); ?>" /></td>
		</tr>
		<tr>
			<td><?php _e( 'Location Lattitude' ); ?></td>
			<td><input type="text" id="location_lat" name="location_lat" value="<?php esc_attr_e( $location_lat ); ?>" /></td>
		</tr>
		<tr>
			<td><label for="location_details"><?php _e( 'Location Details' ); ?></label></td>
			<td><textarea name="location_details" id="location_details" rows="5" placeholder="Can use HTML tag."><?php esc_html_e( $location_details ); ?></textarea></td>
		</tr>
	</tbody>
</table>