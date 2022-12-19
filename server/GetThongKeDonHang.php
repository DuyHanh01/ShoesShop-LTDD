<?php
include "Connect.php";
$query = "SELECT COUNT(orderid) AS TatCaDonHang, (SELECT COUNT(orderid) FROM `order` WHERE statusid =1) AS DangChoDuyet, (SELECT COUNT(orderid) FROM `order` WHERE statusid =2) AS DaDuyet,(SELECT COUNT(orderid) FROM `order` WHERE statusid =3) AS DangGiao, (SELECT COUNT(orderid) FROM `order` WHERE statusid =4) AS DaGiaoHang,(SELECT COUNT(orderid) FROM `order` WHERE statusid =5) AS DaHuy FROM `order`";
$data = mysqli_query($conn, $query);
$result = array();
while ($row = mysqli_fetch_assoc($data)) {
	 $result[] = ($row);
}
// print_r($result);
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

