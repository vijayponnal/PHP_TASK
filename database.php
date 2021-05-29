<?php
session_start();
$con = mysqli_connect("localhost","root","admin123","php_task");
if(!$con)
{
	echo "ERROR:".mysqli_error();
}
?>