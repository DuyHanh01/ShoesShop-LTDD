<?php
 include "connect.php";
$user = $_POST['username'];
$pass= $_POST['password'];
// $roleid = $_POST['roleid'];

// check data

$query = "SELECT * FROM `account` WHERE username = '$user'";
$data = mysqli_query($conn, $query);
$numrow = mysqli_num_rows($data);

if($numrow >  0) {
	$arr = [
		'success' => false,
		'message'=> "Ten dang nhap da ton tai"
	];
}else{
	$data = mysqli_query($conn, $query);
	if ($data == true) {
		$arr = [
			'success' => true,
			'message'=> "thanh cong",
			'result'=> []
		];
	}else{
		$arr = [
			'success' => false,
			'message' => " khong thanh cong",
			'result'=> []
		];
	}	
}
print_r(json_encode($arr));
 
?>