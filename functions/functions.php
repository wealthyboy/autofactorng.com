<?php 

function dd($expression){
	echo "<pre>";
	   var_dump($expression);
	       die();
	echo "</pre>";
}

function output_message($message =""){
	if(!empty($message))
	{
		$output = "<div class=\"alert alert-error alert-dismissable\">
		<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
		<span class=\"glyphicon glyphicon-exclamation-sign\"></span>&nbsp;{$message}</div>";
		return $output;
	}
	else{
		return "";
	}
}
function message($message ="",$status=""){
	if(!empty($message))
	{  
		if( $status == 'error') { 
			
			$output = "<div class=\"alert alert-error alert-dismissable\">
			<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
			<span class=\"glyphicon glyphicon-exclamation-sign\"></span>&nbsp;{$message}</div>";
			return $output;
		}
		if( $status == 'success') {
				
			$output = "<div class=\"alert  alert-success \">
			<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
			
			<span class=\"glyphicon glyphicon-check\"></span>&nbsp; Yeah &nbsp;{$message}</div>";
			return $output;
		}
		
		
	}
	else{
		return "";
	}
}







?>