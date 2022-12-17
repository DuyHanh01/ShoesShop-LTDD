<?php
	include "connect.php";
	$salesid = $_POST['salesid'];
	$chitiet=$_POST['chitiet'];
	// $salesid = 13;
	// $chitiet='[{"id":2,"images":"https://vcdn-giaitri.vnecdn.net/2020/07/06/air-jordan-1-dior-1815-1594004966.jpg","name":"Nike Dior"},{"id":3,"images":"https://shopgiayreplica.com/wp-content/uploads/2020/11/jordan-1-high-travis-scott.jpg","name":"Jordan 1 Travis Scott"}]';
	$json=json_decode($chitiet,true);
   foreach ($json as $key => $value) {
   	$query='DELETE FROM `saledetails` WHERE id = '.$value["id"].' AND salesid = '.$salesid.'';
      $data=mysqli_query($conn,$query);
            }
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