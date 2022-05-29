<form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="battery_filter">
<input type="hidden" name="cat_id" value="<?= $cat_id; ?>">
	<p>
		Volts
		<input type="text" name="battery-volt" value="12" readonly="readonly">
	</p>
	<p>
		Ampere-Hour(AH)
		<select id="battery_amp" name="battery-amp">
			<option value="45">45</option>
			<option value="62">62</option>
			<option value="65">65</option>
			<option value="75">75</option>
			<option value="80">80</option>
			<option value="90">90</option>
			<option value="100">100</option>
			<option value="120">120</option>
			<option value="150">150</option>
			<option value="200">200</option>
		</select>
	</p>
	<p>
		<input type="submit" name="filter_battery" value="SEARCH">
	</p>
</form>

<form id="battery_brand_filter">
<input type="hidden" name="cat_id" value="<?= $cat_id; ?>">
	<p>
	<select name="battery-brand">
		<option value="">Or search by brand</option>
		<?php
			$data = mysqli_query($GLOBALS['dbc'], "SELECT * FROM product_sub_cats WHERE cat_id = 8");
			while($row = mysqli_fetch_array($data)) { ?>
				<option value="<?= $row['name'] ?>"><?= $row['name'] ?></option>
		<?php
			} ?>
	</select>
	</p>
	<p>
		<input type="submit" name="filter-battery-brand" value="Search">
	</p>
</form>