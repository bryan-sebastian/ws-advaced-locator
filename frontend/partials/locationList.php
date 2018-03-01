<div id="ws-location-list" class="ws-container <?php echo ( $categories ) ? 'have-categories' : '' ?> <?php echo ( $search ) ? 'have-search' : '' ?> <?php echo ( $locations ) ? 'have-location' : '' ?>">
	<div class="ws-preloader"></div>
	<?php if ( $categories ): ?>
		<select name="ws-categories" id="ws-categories">
			<option>- Select Categories -</option>
			<?php foreach ( $categories as $category ): ?>
				<option value="<?php echo $category->slug ?>"><?php echo $category->name ?></option>
			<?php endforeach ?>
		</select>
	<?php endif ?>

	<?php if ( $search && $locations ): ?>
		<input type="text" name="ws-search" id="ws-search">
	<?php endif ?>

	<div id="ws-location">
		<ul>
			<li>Loading Locations..</li>
		</ul>
	</div>
</div>

<?php wp_reset_postdata() ?>