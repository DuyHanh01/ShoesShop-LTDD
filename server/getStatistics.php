<?php
	include "connect.php";
	$month = $_POST['month'];
	$year = $_POST['year'];
	$query = 'SELECT COUNT(`orderid`) AS count, MONTH(bookingdate) AS month,YEAR(bookingdate) AS year ,SUM(`total`) AS turnover FROM `order` WHERE YEAR(bookingdate) = "'.$year.'" AND MONTH(bookingdate) = "'.$month.'" AND payment = 1';
	$data = mysqli_query($conn, $query);
	$result = array();
	while ($row = mysqli_fetch_assoc($data)) {
		$query1 = 'SELECT SUM(`quantity`) AS sellnumber FROM `orderdetails` d,`order` o  WHERE o.orderid = d.orderid AND YEAR(bookingdate) = "'.$year.'" AND MONTH(bookingdate) = "'.$month.'" AND payment = 1';
		$data1 = mysqli_query($conn,$query1);
   		while($row1 = mysqli_fetch_assoc($data1)){
   			$item = ($row1["sellnumber"]);
   		}
   		$row["sellnumber"] = $item;
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