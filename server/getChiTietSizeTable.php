<?php
	include "connect.php";
	
	$query = "SELECT sizeid,shoes.name, shoes.images, s38,s39,s40,s41,s42,s43,s44,s45,s46,s47,s48 FROM sizetable, shoes WHERE shoes.id = sizetable.id";
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