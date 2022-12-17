<?php
include "connect.php";
$sender = $_POST['sender'];
$receiver = $_POST['receiver'];
$content = $_POST['content'];
$timestamp = date_create()->format('Y-m-d H:i:s');
$query = 'INSERT INTO `message`(`mesid`, `sender`, `receiver`, `content`, `timestamp`) VALUES (null,'.$sender.','.$receiver.',"'.$content.'","'.$timestamp.'") ';
$data = mysqli_query($conn, $query);
// print_r($result);
if ($data==true) {
	$arr = [
		'success' => true,
		'message' => "Thanh cong"
	];
}else{
	$arr = [
		'success' => false,
		'message' => "khong thanh cong"
	];
}
print_r(json_encode($arr));
?>