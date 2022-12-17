<?php
	include "connect.php";
	$id = $_POST['id'];
	$accountid =  $_POST['accountid'];
	$content = $_POST['content'];
	
	$query = 'INSERT INTO `review`(`reviewid`, `id`, `accountid`, `content`) VALUES (null,'.$id.','.$accountid.',"'.$content.'")';
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
