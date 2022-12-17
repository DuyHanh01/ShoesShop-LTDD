<?php
include "connect.php";
$id = $_POST['id'];
$query = 'UPDATE `product` SET `statusid`= 2 WHERE id = '.$id.'';
$data = mysqli_query($conn, $query);
if ($data==true) {
	$arr = [
		'success' => true,
		'message' => "Thanh cong"
	];
}else{
	$arr = [
		'success' => false,
		'message' => "khong thanh cong",
	];
}

print_r(json_encode($arr));
?>