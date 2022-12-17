<?php
	include "connect.php";

	$shoesname = $_POST['shoesname'];
	$price = $_POST['price'];
	$size = $_POST['size'];
	$description = $_POST['description'];
	$accountid = $_POST['accountid'];
	// $shoesname = "nike";
	// $price = 2000;
	// $size = 42;
	// $description = "con moi";
	// $accountid = 14;

	$query = 'INSERT INTO `product`(`id`, `shoesname`, `price`, `size`, `description`, `accountid`, `statusid`) VALUES (null,"'.$shoesname.'",'.$price.',"'.$size.'","'.$description.'",'.$accountid.',1)';
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