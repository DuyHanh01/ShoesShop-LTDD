<?php
include "connect.php";

$accountid = $_POST['accountid'];
$enabled = $_POST['enabled'];
$Rolesid = $_POST['rolesid'];

// $statusid = 1;
// if ($statusname == "Đã duyệt") {
// 	$statusid = 2;
// }
// if ($statusname == "Đang giao") {
// 	$statusid = 3;
// }
// if($statusname == "Giao thành công"){
// 	$statusid = 4;
// }
// if ($statusname == "Đã hủy") {
// 	$statusid = 5;
// }

$query = "UPDATE `account` SET `rolesid`=$Rolesid, `enabled`=$enabled WHERE accountid = $accountid";
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