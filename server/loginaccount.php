<?php
 include "connect.php";
$usn = $_POST['username'];
$pass= $_POST['password'];

// check data

$query = "SELECT * FROM account WHERE username = '$usn' and password = '$pass'";
$data = mysqli_query($conn, $query);
$result = array();
while ($row = mysqli_fetch_assoc($data)) {
	$result[] = ($row);
	// code...
}
if(!empty($result)) {
	$arr = [
		'success' => true,
		'message'=> "Thanh cong",
		'result' => $result
	];
}else{
	$arr = [
		'success' => false,
		'message'=> "khong thanh cong",
		'result' => $result
	];
}




print_r(json_encode($arr));
 
?>