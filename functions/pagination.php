<?php
// function generate_page_links($cat_id, $sub_cat_id, $cur_page, $num_pages) {
// 	$arr_k = array_keys($_GET);
// 	$arr_v = array_values($_GET);
// 	$arr_kv = array();
// 	$uri = [];

// 	$cur_location_link = '?'; //begin building GET
// //	print_r($arr_k);
// 	//die();
// 	for ($i = 0; $i < count($arr_k); $i++) {
// 		//avoid multiple page parameter
// 		if ($arr_k[$i] != 'page'){
// 			$arr_kv[] = $arr_k[$i] . '=' . $arr_v[$i];
// 			$uri[] = $arr_v[$i];

// 		}
// 	}
	
	
	

// 	$cur_location_link .= implode('&', $arr_kv);
	
// 	$ur = implode('/', $uri);
	

	

// 	$page_link='';
// 	if ($cur_page > 1){
// 		$page_link .= ' <a class="page_link" href="/'
		
// 		    .$ur.
// 		    '/'.($cur_page - 1).'"> <</a> ';
// 	}

// 	$start = 1;
// 	$stop = $num_pages;

// 	if ($cur_page > 3) {
// 		$start = $cur_page - 2;
// 		$page_link .= ' <a class="page_link">...</a>';
// 	}

// 	if (($num_pages - $cur_page) > 2) {
// 		$stop = $cur_page + 2;
// 	}

// 	for($i=$start; $i <= $stop; $i++) {
// 		if ($i == $cur_page){
// 			$page_link .= ' <a class="cur_link">' . $i . '</a> ';
// 		}


// 		else{
// 			$page_link .= ' <a class="page_link" href="/'.$ur.'/'.$i.'">' . $i . '</a> ';
// 		}
// 	}

// 	if (($num_pages - $cur_page) > 2) {
// 		$page_link .= ' <a class="page_link">...</a>';
// 	}

// 	if ($cur_page < $num_pages) {
// 		$page_link .= ' <a class="page_link" href="/'.$ur.'/'.($cur_page + 1).'"> ></a> ';
// 	}

// 	return $page_link;
// }

// function generate_page_links2($cat_id, $cur_page, $num_pages) {
// 	$arr_k = array_keys($_GET);
// 	$arr_v = array_values($_GET);
// 	$arr_kv = array();
// 	$uri = [];
// 	$cur_location_link = '?'; //begin building GET
// 	for ($i = 0; $i < count($arr_k); $i++) {
// 		if ($arr_k[$i] != 'page'){
// 			$arr_kv[] = $arr_k[$i] . '=' . $arr_v[$i];
// 			$uri[] = $arr_v[$i];

// 		}
// 	}
// 	$ur = implode('/', uri);


// 	$cur_location_link .= implode('&', $arr_kv);
// 	if ($cur_page > 1){
// 		$page_link .= ' <a class="page_link" href="/'.$ur.'/'.($cur_page - 1).'"> <</a> ';
// 	}

// 	$start = 1;
// 	$stop = $num_pages;

// 	if ($cur_page > 3) {
// 		$start = $cur_page - 2;
// 		$page_link .= ' <a class="page_link">...</a>';
// 	}

// 	if (($num_pages - $cur_page) > 2) {
// 		$stop = $cur_page + 2;
// 	}

// 	for($i=$start; $i <= $stop; $i++) {
// 		if ($i == $cur_page){
// 			$page_link .= ' <a class="cur_link">' . $i . '</a> ';
// 		}

// 		else{
// 			$page_link .= ' <a class="page_link" href="/'.$ur.'/'.$i.'">' . $i . '</a> ';
// 		}
// 	}

// 	if (($num_pages - $cur_page) > 2) {
// 		$page_link .= ' <a class="page_link">...</a>';
// 	}

// 	if ($cur_page < $num_pages) {
// 		$page_link .= ' <a class="page_link" href="/'.$ur.'/'.($cur_page + 1).'"> ></a> ';
// 	}

// 	return $page_link;
// }
?>

<?php
function generate_page_links($cat_id, $sub_cat_id, $cur_page, $num_pages) {
	$arr_k = array_keys($_GET);
	$arr_v = array_values($_GET);
	$arr_kv = array();
	$cur_location_link = '?'; //begin building GET
	for ($i = 0; $i < count($arr_k); $i++) {
		//avoid multiple page parameter
		if ($arr_k[$i] != 'page'){
			$arr_kv[] = $arr_k[$i] . '=' . $arr_v[$i];
		}
	}

	$cur_location_link .= implode('&', $arr_kv);
	$page_link='';
	if ($cur_page > 1){
		$page_link .= ' <a class="page_link" href="'.$_SERVER['PHP_SELF'].$cur_location_link.'&page='.($cur_page - 1).'"> <</a> ';
	}

	$start = 1;
	$stop = $num_pages;

	if ($cur_page > 3) {
		$start = $cur_page - 2;
		$page_link .= ' <a class="page_link">...</a>';
	}

	if (($num_pages - $cur_page) > 2) {
		$stop = $cur_page + 2;
	}

	for($i=$start; $i <= $stop; $i++) {
		if ($i == $cur_page){
			$page_link .= ' <a class="cur_link">' . $i . '</a> ';
		}


		else{
			$page_link .= ' <a class="page_link" href="'.$_SERVER['PHP_SELF'].$cur_location_link.'&page='.$i.'">' . $i . '</a> ';
		}
	}

	if (($num_pages - $cur_page) > 2) {
		$page_link .= ' <a class="page_link">...</a>';
	}

	if ($cur_page < $num_pages) {
		$page_link .= ' <a class="page_link" href="'.$_SERVER['PHP_SELF'].$cur_location_link.'&page='.($cur_page + 1).'"> ></a> ';
	}

	return $page_link;
}

function generate_page_links2($cat_id, $cur_page, $num_pages) {
	$arr_k = array_keys($_GET);
	$arr_v = array_values($_GET);
	$arr_kv = array();
	$cur_location_link = '?'; //begin building GET
	for ($i = 0; $i < count($arr_k); $i++) {
		if ($arr_k[$i] != 'page'){
			$arr_kv[] = $arr_k[$i] . '=' . $arr_v[$i];
		}
	}

	$cur_location_link .= implode('&', $arr_kv);
	if ($cur_page > 1){
		$page_link .= ' <a class="page_link" href="'.$_SERVER['PHP_SELF'].$cur_location_link.'&page='.($cur_page - 1).'"> <</a> ';
	}

	$start = 1;
	$stop = $num_pages;

	if ($cur_page > 3) {
		$start = $cur_page - 2;
		$page_link .= ' <a class="page_link">...</a>';
	}

	if (($num_pages - $cur_page) > 2) {
		$stop = $cur_page + 2;
	}

	for($i=$start; $i <= $stop; $i++) {
		if ($i == $cur_page){
			$page_link .= ' <a class="cur_link">' . $i . '</a> ';
		}

		else{
			$page_link .= ' <a class="page_link" href="'.$_SERVER['PHP_SELF'].$cur_location_link.'&page='.$i.'">' . $i . '</a> ';
		}
	}

	if (($num_pages - $cur_page) > 2) {
		$page_link .= ' <a class="page_link">...</a>';
	}

	if ($cur_page < $num_pages) {
		$page_link .= ' <a class="page_link" href="'.$_SERVER['PHP_SELF'].$cur_location_link.'&page='.($cur_page + 1).'"> ></a> ';
	}

	return $page_link;
}
?>




