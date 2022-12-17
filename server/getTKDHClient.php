<?php
include "connect.php";
$query = "SELECT COUNT(id) AS TatCaDonHang, (SELECT COUNT(id) FROM `product` WHERE statusid =1) AS DangChoDuyet, (SELECT COUNT(id) FROM `product` WHERE statusid =2) AS DaDuyet,(SELECT COUNT(id) FROM `product` WHERE statusid =3) AS DangGiao, (SELECT COUNT(id) FROM `product` WHERE statusid =4) AS DaGiaoHang,(SELECT COUNT(id) FROM `product` WHERE statusid =5) AS DaHuy FROM `product`";
$data = mysqli_query($conn, $query);
$result = array();
while ($row = mysqli_fetch_assoc($data)) {
	 $result[] = ($row);
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