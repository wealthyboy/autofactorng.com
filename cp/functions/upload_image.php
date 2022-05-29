<?php
	function upload_image($img1, $img2 = '', $img3 = '') {
		$image_upload_stat = array(
			'image_1' => NULL,
			'image_2' => NULL,
			'image_3' => NULL
			);

		if (!empty($img1['name'])) {
			$img = str_replace(' ', '_', $img1['name']);
			move_uploaded_file($img1['tmp_name'], IMAGES_PATH . $img);
			if ($img1['error'] == 0) {
				$image_upload_stat['image_1'] = true;
			}

			else {
				$image_upload_stat['image_1'] = false;
			}
		}

		if (!empty($img2['name'])) {
			$img = str_replace(' ', '_', $img2['name']);
			move_uploaded_file($img2['tmp_name'], IMAGES_PATH . $img);
			if ($img2['error'] == 0) {
				$image_upload_stat['image_2'] = true;
			}

			else {
				$image_upload_stat['image_2'] = false;
			}
		}

		if (!empty($img3['name'])) {
			$img = str_replace(' ', '_', $img3['name']);
			move_uploaded_file($img3['tmp_name'], IMAGES_PATH . $img);
			if ($img3['error'] == 0) {
				$image_upload_stat['image_3'] = true;
			}

			else {
				$image_upload_stat['image_3'] = false;
			}
		}

		return $image_upload_stat;
	}


	function update_image($img1, $img2 = '', $img3 = '') {
		if (!empty($img1['name'])) {
			$img = str_replace(' ', '_', $img1['name']);
			move_uploaded_file($img1['tmp_name'], IMAGES_PATH . $img);
		}

		if (!empty($img2['name'])) {
			$img = str_replace(' ', '_', $img2['name']);
			move_uploaded_file($img2['tmp_name'], IMAGES_PATH . $img);
		}

		if (!empty($img3['name'])) {
			$img = str_replace(' ', '_', $img3['name']);
			move_uploaded_file($img3['tmp_name'], IMAGES_PATH . $img);
		}
	}
?>