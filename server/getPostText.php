<?php
	include "connect.php";
	
	$query = "SELECT id,shoesname,price,size,description, account.name,hinh1,hinh2,hinh3,hinh4,hinh5,hinh6 FROM product,account WHERE product.accountid = account.accountid AND statusid = 2";
	$data = mysqli_query($conn, $query);
	$result = array();

	while ($row = mysqli_fetch_assoc($data)) {
		$result[] = ($row);
	}
	if (!empty($result)) {
		$arr = [
				'success' => true,
				'message' => "thanh cong",
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