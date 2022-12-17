<?php
	include "connect.php";

	$statusid=$_POST['statusid'];
	if($statusid==0){
		$query = 'SELECT product.*, statusname, name FROM `product` INNER JOIN status ON product.statusid = status.statusid INNER JOIN account ON product.accountid = account.accountid GROUP BY id ORDER BY status.statusid ASC';
	}else{
	    $query = 'SELECT product.*, statusname, name FROM `product` INNER JOIN status ON product.statusid = status.statusid INNER JOIN account ON product.accountid = account.accountid WHERE status.statusid = '.$statusid.' GROUP BY id ORDER BY status.statusid ASC';
	}
	$data = mysqli_query($conn, $query);
	$list = array();
	while ($row = mysqli_fetch_assoc($data)) {
   		$query1 = 'SELECT image FROM images WHERE id = '.$row["id"].' ';
   		$data1 = mysqli_query($conn,$query1);
   		$item=array();
   		while($row1 = mysqli_fetch_assoc($data1)){
   			$item[] = $row1;
   		}
   		$row["images"] = $item;
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