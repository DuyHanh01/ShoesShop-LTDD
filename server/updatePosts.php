<?php
include "connect.php";

$id = $_POST['id'];
$statusname = $_POST['statusname'];

$statusid = 1;
if ($statusname == "Đang chờ duyệt") {
	$statusid = 1;
}
if ($statusname == "Đã duyệt") {
	$statusid = 2;
}


$query = "UPDATE `product` SET `statusid`= $statusid WHERE `id` = $id";
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