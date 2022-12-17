<?php
	include "connect.php";
	$statusid = $_POST['statusid'];
	if($statusid==0){
		$query = 'SELECT orderdetails.orderid, orderdetails.id, bookingdate, name,address,phone, email, orderdetails.quantity, orderdetails.size, order.total, status.statusname FROM `order`, orderdetails, status WHERE order.orderid = orderdetails.orderid AND order.statusid = status.statusid   GROUP BY order.orderid ORDER BY status.statusid';
	}else{
	    $query = 'SELECT orderdetails.orderid, orderdetails.id, bookingdate, name,address,phone, email, orderdetails.quantity, orderdetails.size, order.total, status.statusname FROM `order`, orderdetails, status WHERE order.orderid = orderdetails.orderid AND order.statusid = status.statusid and order.statusid= '.$statusid.'  GROUP BY order.orderid ORDER BY status.statusid';
	}
	
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