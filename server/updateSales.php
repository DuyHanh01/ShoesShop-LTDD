<?php
	include "connect.php";
	$salesid = $_POST['salesid'];
	$salesname = $_POST['salesname'];
	$startday = $_POST['startday'];
	$endday = $_POST['endday'];
	$content = $_POST['content'];
	$percent = $_POST['percent'];
	$rest = substr($percent, 0, -1);
	$createdate = date_create()->format('Y-m-d H:i:s');
	$query = 'UPDATE `sales` SET `startday`="'.$startday.'",`endday`="'.$endday.'",`salesname`="'.$salesname.'",`content`="'.$content.'",`percent`='.$rest.' WHERE salesid='.$salesid.'';
		$data = mysqli_query($conn, $query);
	$query1 = 'SELECT s.id, s.price AS price FROM `saledetails` d, `shoes` s,`sales` m WHERE d.id = s.id AND m.salesid = d.salesid AND d.salesid = '.$salesid.'';
		$data1 = mysqli_query($conn, $query1);
		while ($row = mysqli_fetch_assoc($data1)) {
             $m[] = ($row);
         }
         if(!empty($m)){
	         	foreach ($m as $key => $value) {
	         	$query2 = 'UPDATE `saledetails` SET `salesprice`='.$value["price"].' - '.$rest.'*'.$value["price"].'/100 WHERE id = '.$value["id"].'';
	         	$data2 = mysqli_query($conn, $query2);
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