<?php
include "connect.php";
$query = 'SELECT brandid FROM brand';
$data = mysqli_query($conn,$query);
while ($row = mysqli_fetch_assoc($data)) {
	$x[]=($row);
}
$query1 = 'SELECT DISTINCT d.orderid, s.brandid FROM `orderdetails` d LEFT JOIN `order` o ON o.orderid = d.orderid LEFT JOIN shoes s ON s.id = d.id LEFT JOIN brand ON s.brandid = brand.brandid WHERE payment = 1';
$data1 = mysqli_query($conn, $query);
while ($row1 = mysqli_fetch_assoc($data1)) {
	$a[] = ($row1);
}
foreach ($x as $key => $value) {
	
}
if (!empty($result)) {
			$arr = [
				'success' => true,
				'message' => "Thanh cong",
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