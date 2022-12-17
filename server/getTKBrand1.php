<?php
include "connect.php";
$query = 'SELECT brand.brandid, brand.brandname, SUM(orderdetails.quantity) AS "countspdaban", SUM(orderdetails.total) AS "turnover"  FROM brand LEFT JOIN shoes ON brand.brandid= shoes.brandid RIGHT JOIN orderdetails ON orderdetails.id= shoes.id LEFT JOIN `order` ON orderdetails.orderid = `order`.`orderid`  WHERE  `order`.`payment`=true GROUP BY brand.brandname';
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