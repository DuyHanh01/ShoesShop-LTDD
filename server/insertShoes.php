<?php
	include "connect.php";

	$name = $_POST['name'];
	$brandid = $_POST['brandid'];
	$price = $_POST['price'];
	$description = $_POST['description'];
	$dateupdate = date_create()->format('Y-m-d H:i:s');
	$new = $_POST['new'];
	$images = $_POST['images'];
	$exist = $_POST['exist'];
	$query = "SELECT * FROM shoes WHERE name = '$name'";
	$data = mysqli_query($conn, $query);
	$numrow = mysqli_num_rows($data);
	if($numrow >  0) {
		$arr = [
			'success' => false,
			'message'=> "Sản pham da ton tai"
		];
	}else{
		$query1 = "INSERT INTO `shoes`(`name`, `dateupdate`, `price`, `images`, `stock`, `review`, `rate`, `purchased`, `shoesnew`, `categoryid`, `description`, `updateby`, `brandid`, `active`) VALUES ('$name','$dateupdate','$price','$images',0,null,null,0,'$new',1,'$description',null,'$brandid','$exist')";
		$data1 = mysqli_query($conn, $query1);
		if ($data1 == true) {
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
	}
	print_r(json_encode($arr));
	
?>