<?php
	include "connect.php";
	$salesid = $_POST['salesid'];
	$updateby = $_POST['updateby'];
	$chitiet=$_POST['chitiet'];
	// $salesid = 10;
	// $updateby = 8;
	// $chitiet='[{"id":4,"images":"https://vcdn-giaitri.vnecdn.net/2020/07/06/air-jordan-1-dior-1815-1594004966.jpg","name":"Nike Dior"},{"id":3,"images":"https://shopgiayreplica.com/wp-content/uploads/2020/11/jordan-1-high-travis-scott.jpg","name":"Jordan 1 Travis Scott"}]';
	$query="SELECT `salesid` AS salesid, `percent` AS percent FROM `sales` WHERE salesid = $salesid";
	$data = mysqli_query($conn,$query);
    while ($row = mysqli_fetch_assoc($data)) {
             $m = ($row);
         }
         if(!empty($m)){
         	$json=json_decode($chitiet,true);
            foreach ($json as $key => $value) {
                $query='INSERT INTO `saledetails`(`salesid`, `id`, `salesprice`, `updateby`) VALUES ('.$salesid.','.$value["id"].', '.$value["price"].' - '.$m["percent"].'*'.$value["price"].'/100,'.$updateby.')';
                $data=mysqli_query($conn,$query);
            }
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