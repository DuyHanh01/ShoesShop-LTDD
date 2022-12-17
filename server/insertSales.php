<?php
	include "connect.php";
	$salesname = $_POST['salesname'];
	$startday = $_POST['startday'];
	$endday = $_POST['endday'];
	$content = $_POST['content'];
	$percent = $_POST['percent'];
	$rest = substr($percent, 0, -1);
	$createdate = date_create()->format('Y-m-d H:i:s');
	$query = 'INSERT INTO `sales`(`salesid`, `startday`, `endday`, `salesname`, `createdate`, `content`, `percent`) VALUES (null,"'.$startday.'","'.$endday.'","'.$salesname.'","'.$createdate.'","'.$content.'",'.$rest.')';
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