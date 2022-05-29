<form  action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="wheel_tyre_filter">
<input type="hidden" name="cat_id" value="<?= $cat_id; ?>">
<input type="hidden" name="sub_cat_id" value="<?= $sub_cat_id; ?>">
	<p>
		Year
		<select id="year" name="year">
			<option value="">Select Year</option>
			<?php require('modules/year_select'); ?>
		</select>
	</p>
	<p>
		Make
		<select id="make" name="make">
			<option>Select Make</option>
		</select>
	</p>
	<p>
		Model
		<select id="model" name="model">
			<option>Select Model</option>
		</select>
	</p>
	<p>
		<input type="submit" name="filter_wheel" value="SEARCH">
	</p>
</form>

<form id="tyre_brand_filter">
<input type="hidden" name="cat_id" value="<?= $cat_id; ?>">
<input type="hidden" name="sub_cat_id" value="<?= $sub_cat_id; ?>">
	<p>
	<select id="wheel-rim" name="rim-size">
		<option value="">Or search by rim</option>
			<?php  
			for ($i=14; $i<=22; $i++) { ?>
		  		<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php } ?>
		</select>
	</p>
	<p>
		<input type="submit" name="filter-rim-size" value="Search">
	</p>
</form>