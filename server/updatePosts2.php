<?php
	include "connect.php";
	
	$id = $_POST['id'];
	$shoesname = $_POST['shoesname'];
	$price = $_POST["price"];
	$size =  $_POST["size"];
	$description = $_POST["description"];
	$hinh1 = $_POST['hinh1'];
	$hinh2 = $_POST['hinh2'];
	$hinh3 = $_POST['hinh3'];
	$hinh4 = $_POST['hinh4'];
	$hinh5 = $_POST['hinh5'];
	$hinh6 = $_POST['hinh6'];

	$query = "UPDATE `product` SET `shoesname`='$shoesname',`price`='$price',`size`='$size',`description`='$description',`hinh1`='$hinh1',`hinh2`='$hinh2',`hinh3`='$hinh3',`hinh4`='$hinh4',`hinh5`='$hinh5',`hinh6`= '$hinh6' WHERE `id`='$id' ";
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