<?php
	include "connect.php";
	$xday = 0;
	$xmonth = 0;
	$xyear = 0;
	$xdtt = 0;
	$xctt = 0;
	$xdh = 0;
	$orderday = 0;
	$ordermonth = 0;
	$orderyear = 0;
	$orderdtt = 0;
	$orderctt = 0;
	$orderdh = 0;
	$date = date("Y-m-d");
	$day = date("d");
	$month = date("m");
	$year = date("Y");

	$query = 'SELECT total, payment FROM `order` WHERE DAY(bookingdate) = '.$day.'';
	$data = mysqli_query($conn,$query);
	while($row = mysqli_fetch_assoc($data)){
		$a[] = ($row);
	}
	if(!empty($a)){
		foreach ($a as $key => $value) {
			if($value["payment"]==1){
				$xday+=$value["total"];
				$orderday+=1;
			}
		}
	}

	$query1 = 'SELECT total,payment FROM `order` WHERE MONTH(bookingdate) = '.$month.'';
	$data1 = mysqli_query($conn,$query1);
	while($row = mysqli_fetch_assoc($data1)){
		$b[] = ($row);
	}
	if(!empty($b)){
		foreach ($b as $key => $value) {
			if($value["payment"]==1){
				$xmonth+=$value["total"];
				$ordermonth+=1;
			}
		}
	}

	$query2 = 'SELECT total,payment FROM `order` WHERE YEAR(bookingdate) = '.$year.'';
	$data2 = mysqli_query($conn,$query2);
	while($row = mysqli_fetch_assoc($data2)){
		$c[] = ($row);
	}
	if(!empty($c)){
		foreach ($c as $key => $value) {
			if($value["payment"]==1){
				$xyear+=$value["total"];
				$orderyear+=1;
			}
		}
	}

	$query3 = 'SELECT total,payment FROM `order`';
	$data3 = mysqli_query($conn,$query3);
	while($row = mysqli_fetch_assoc($data3)){
		$d[] = ($row);
	}
	if(!empty($d)){
		foreach ($d as $key => $value) {
			if($value["payment"]==1){
				$xdtt+=$value["total"];
				$orderdtt+=1;
			}
		}
	}

	$query4 = 'SELECT total,statusid,payment FROM `order`';
	$data4 = mysqli_query($conn,$query4);
	while($row = mysqli_fetch_assoc($data4)){
		$e[] = ($row);
	}
	if(!empty($e)){
		foreach ($e as $key => $value) {
			if($value["statusid"]==5){
				$xdh+=$value["total"];
				$orderdh+=1;
			}else{
				if($value["payment"]==0){
					$xctt+=$value["total"];
					$orderctt+=1;
				}
			}
		}
	}

	$k = array();
	$k["day"] = $day;
	$k["orderday"] = $orderday;
	$k["totalday"] = $xday;
	$k["month"] = $month;
	$k["ordermonth"] = $ordermonth;
	$k["totalmonth"] = $xmonth;
	$k["year"] = $year;
	$k["orderyear"] = $orderyear;
	$k["totalyear"] = $xyear;
	$k["orderdtt"] = $orderdtt;
	$k["totaldtt"] = $xdtt;
	$k["orderctt"] = $orderctt;
	$k["totalctt"] = $xctt;
	$k["orderdh"] = $orderdh;
	$k["totaldh"] = $xdh;
	$result[] = ($k);
	if (!empty($k)) {
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