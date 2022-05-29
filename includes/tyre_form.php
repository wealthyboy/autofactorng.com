<form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="wheel_tyre_filter">
<input type="hidden" name="cat_id" value="<?= $cat_id; ?>">
<input type="hidden" name="sub_cat_id" value="<?= $sub_cat_id; ?>">
	<p>
		Rim
		<select id="wheel-rim" name="wheel-rim">
			<?php  
			for ($i=14; $i<=22; $i++) { ?>
		  		<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php } ?>
		</select>
	</p>
	<p>
		Width
		<select id="wheel-width" name="wheel-width">
			<option value="165">165</option>
			<option value="175">175</option>
			<option value="185">185</option>
			<option value="195">195</option>
			<option value="205">205</option>
			<option value="215">215</option>
			<option value="225">225</option>
			<option value="235">235</option>
			<option value="245">245</option>
			<option value="255">255</option>
			<option value="265">265</option>
			<option value="275">275</option>
			<option value="285">285</option>
			<option value="295">295</option>
			<option value="305">305</option>
			<option value="315">315</option>
			<option value="325">325</option>
		</select>
	</p>
	<p>
		Profile
		<select id="wheel-profile" name="wheel-profile">
			<option value="30">30</option>
	 		<option value="35">35</option>
	 		<option value="40">40</option>
	 		<option value="45">45</option>
	 		<option value="50">50</option>
	 		<option value="55">55</option>
	 		<option value="60">60</option>
	 		<option value="65">65</option>
	 		<option value="70">70</option>
	 		<option value="75">75</option>
		</select>
	</p>
	<p>
		<input type="submit" name="filter_wheel" value="SEARCH">
	</p>
</form>

<form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="tyre_brand_filter">
<input type="hidden" name="cat_id" value="<?= $cat_id; ?>">
<input type="hidden" name="sub_cat_id" value="<?= $sub_cat_id; ?>">
	<p>
	<select name="tyre-brand">
		<option value="">Or search by brand</option>
		<?php
			$data = mysqli_query($GLOBALS['dbc'], "SELECT * FROM product_types WHERE cat_id = 6 AND sub_cat_id = 24");
			while($row = mysqli_fetch_array($data)) { ?>
				<option value="<?= $row['name'] ?>"><?= $row['name'] ?></option>
		<?php
			} ?>
	</select>
	</p>
	<p>
		<input type="submit" name="filter-tyre-brand" value="Search">
	</p>
</form>