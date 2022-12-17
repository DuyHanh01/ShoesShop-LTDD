<?php
include "connect.php";
$sender = $_POST['sender'];
$receiver = $_POST['receiver'];
$query = 'SELECT * FROM `message` WHERE sender = '.$sender.' AND receiver ='.$receiver.'  UNION SELECT * FROM `message` WHERE sender = '.$receiver.' AND receiver = '.$sender.'';
$data = mysqli_query($conn, $query);
$result = array();
while ($row = mysqli_fetch_assoc($data)) {
	 $result[] = ($row);
}
if (!empty($result)) {
	$arr = [
		'success' => true,
		'message' => "Thanh cong",
		'result' => $result
	];
}else{
	$arr = [
		'success' => false,
		'message' => "khong thanh cong",
		'result' => $result
	];
}
print_r(json_encode($arr));
?>