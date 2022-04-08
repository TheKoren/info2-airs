<?php
function opendb(){
			$link = mysqli_connect("localhost", "root", "") or die("connection error" . mysqli_error());
			mysqli_select_db($link, "repulosdb");
			mysqli_query($link, "set character_set_results='utf-8'");
			return $link;
	
}
?>