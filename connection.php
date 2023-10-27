<?php
date_default_timezone_set("Asia/Manila");
$date=date('F j, Y g:i:a');
	$con = mysqli_connect("127.0.0.1","root","","campusconnect");
	if(mysqli_connect_errno()) {
		echo "Connection failed:".mysqli_connect_error();
		exit;
	}
?>	