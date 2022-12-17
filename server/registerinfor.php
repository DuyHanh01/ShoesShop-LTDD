<?php
 include "connect.php";

$user = $_POST['username'];
$nm = $_POST['name'];
$addr= $_POST['address'];
$phonenum = $_POST['phone'];


$query = "UPDATE account SET name ='$nm', address='$addr', phone ='$phonenum' WHERE username = '$user'";
$data = mysqli_query($conn, $query);
	if ($data == true) {
		$arr = [
			'success' => true,
			'message'=> "thanh cong",
		];
	}else{
		$arr = [
			'success' => false,
			'message' => " khong thanh cong",

		];
	}
	print_r(json_encode($arr));
 
?>