<?php
include "connect.php";
$brandid=$_POST['brandid'];
$query = 'SELECT shoes.*, saledetails.salesprice, sales.startday, sales.endday,sales.percent from shoes LEFT JOIN saledetails ON shoes.id = saledetails.id LEFT JOIN sales on sales.salesid=saledetails.salesid WHERE shoes.brandid='.$brandid.' GROUP BY shoes.id';
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