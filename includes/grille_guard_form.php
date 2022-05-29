<form id="grille_guard_filter">
<input type="hidden" name="grille-option" id="grille_option" value="<?= $grille_option; ?>">
<input type="hidden" name="cat_id" value="<?= $cat_id; ?>">
<input type="hidden" name="sub_cat_id" value="<?= $sub_cat_id; ?>">
	<p>
		Make
		<select id="grille_make" name="grille-make">
			<option value="">Select Make</option>
			<?php
				while($row = mysqli_fetch_array($make_list)) { ?>
					<option value="<?= $row['id']; ?>"><?= $row['name']; ?></option>
			<?php }
			?>
		</select>
	</p>
	<p>
		Model
		<select id="grille_model" name="grille-model">
			<option>Select Model</option>
		</select>
	</p>
	<p>
		<input type="submit" name="filter-grille" id="filter_grille" value="SEARCH">
	</p>
</form>