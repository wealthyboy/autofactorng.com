<?php
	function pagination($num_pages, $cur_page, $table_name, $prod_cat, $prod_sub_cat) {
		$page_link = '';
		//$cur_url = $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'];
		$cur_url = "index.php?tbl=$table_name&cat_id=$prod_cat";
		$cur_url .= (is_null($prod_sub_cat) ? '' : '&sub_cat_id='.$prod_sub_cat);

		if ($cur_page > 1){
			$page_link .= ' <li><a href="'.$cur_url.
			'&page='.($cur_page - 1).'"> <</a></li> ';
		}

		$start = 1;
		$stop = $num_pages;

	if ($cur_page > 3) {
		$start = $cur_page - 2;
		$page_link .= ' <li class="disabled"><a>...</a></li>';
	}

	if (($num_pages - $cur_page) > 2) {
		$stop = $cur_page + 2;
	}

	for($i=$start; $i <= $stop; $i++) {
		if ($i == $cur_page){
			$page_link .= ' <li class="active"><a>' . $i . '</a></li> ';
		}

		else{
			$page_link .= ' <li><a href="'.$cur_url.'&page='.$i.'">' . $i . '</a></li> ';
		}
	}

	if (($num_pages - $cur_page) > 2) {
		$page_link .= ' <li class="disabled"><a>...</a><li>';
	}

	if ($cur_page < $num_pages) {
		$page_link .= ' <li><a href="'.$cur_url.'&page='.($cur_page + 1).'"> ></a></li> ';
	}

	return $page_link;
}
?>