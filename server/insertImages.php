<?php
	include "connect.php";

	$id = $_POST['id'];
	$hinh1 = $_POST['hinh1'];
	$hinh2 = $_POST['hinh2'];
	$hinh3 = $_POST['hinh3'];
	$hinh4 = $_POST['hinh4'];
	$hinh5 = $_POST['hinh5'];
	$hinh6 = $_POST['hinh6'];

	$query = "INSERT INTO `images`(`id`, `hinh1`, `hinh2`, `hinh3`, `hinh4`, `hinh5`, `hinh6`) VALUES ('$id','$hinh1','$hinh2','$hinh3','$hinh4','$hinh5','$hinh6')";
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