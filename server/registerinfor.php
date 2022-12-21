<?php
 include "connect.php";

$user = $_POST['username'];
$nm = $_POST['name'];
$pass = $_POST['pass'];
$addr= $_POST['address'];
$email = $_POST['email'];

// $user = "0369880609";
// $nm = "a";
// $pass = "123";
// $addr= "gia lai";
// $email = "trananhvuiato@gmail.com";


$query = "SELECT * FROM `account` WHERE username = '$user'";
$data = mysqli_query($conn, $query);
$numrow = mysqli_num_rows($data);

if($numrow >  0) {
	$arr = [
		'success' => false,
		'message'=> "Ten dang nhap da ton tai"
	];
}else{
	$query = 'INSERT INTO `account`(`accountid`, `username`, `password`, `rolesid`,`name`,`address`,`email`, `enabled`) VALUES (null,"'.$user.'","'.$pass.'",3,"'.$nm.'","'.$addr.'","'.$email.'",1)';

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

//insert


print_r(json_encode($arr));
 
?>