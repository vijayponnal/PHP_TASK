<?php
function get_safe_value($string)
{
	global $con;
	if(!empty($string))
	{
		$str = mysqli_real_escape_string($con,$string);
		return $str;
	}
}
function redir($url)
{
	echo "<script>window.location.href='$url';</script>";
}

function pr($arr)
{
	echo "<pre>";
	print_r($arr);
}

function prx($arr)
{
	echo "<pre>";
	print_r($arr);
	die();
}

function getUserDetailsByid($uid=''){
	global $con;
	$data['name']='';
	$data['email']='';
	$data['mobile']='';
	$data['bill_to_address']='';
	$data['ship_to_address']='';
	$cust_res = mysqli_query($con,"select name,email,mobile,bill_to_address,ship_to_address from customers where id='$uid'");
	if(mysqli_num_rows($cust_res)>0)
	{
		$row_cust=mysqli_fetch_assoc($cust_res);
		$data['name']=$row_cust['name'];
		$data['email']=$row_cust['email'];
		$data['mobile']=$row_cust['mobile'];
		$data['bill_to_address']=$row_cust['bill_to_address'];
		$data['ship_to_address']=$row_cust['ship_to_address'];
	}
	return $data;
}

function getcompanyDetails(){
	global $con;
	$data['id']='';
	$data['cmp_name']='';
	$data['cmp_email']='';
	$data['cmp_mobile']='';
	$data['cmp_address']='';
	$res_cmp = mysqli_query($con,"select id,cmp_name,cmp_email,cmp_mobile,cmp_address from company");
	if(mysqli_num_rows($res_cmp)>0)
	{
		$row_cmp =mysqli_fetch_assoc($res_cmp);
		$data['id']=$row_cmp['id'];
		$data['cmp_name']=$row_cmp['cmp_name'];
		$data['cmp_email']=$row_cmp['cmp_email'];
		$data['cmp_mobile']=$row_cmp['cmp_mobile'];
		$data['cmp_address']=$row_cmp['cmp_address'];
	}
	return $data;
}

function getSalesOrderDetailsById($id)
{
	global $con;
	$res = mysqli_query($con,"select * from sales_order where so_order_id='$id'");
	if(mysqli_num_rows($res)>0)
	{
		$row=mysqli_fetch_assoc($res);
		return $row;
	}
	
}

?>
