
<?php
include "connect.php";

 $query = 'SELECT * FROM shoes, saledetails,sales WHERE shoes.id=saledetails.id and sales.salesid= saledetails.salesid and sales.startday<=CURRENT_DATE() and sales.endday>CURRENT_DATE()  GROUP BY shoes.id limit 10';

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