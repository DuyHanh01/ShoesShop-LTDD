
<?php
include "connect.php";

$saleid = $_POST['saleid'];
if($saleid==0){
	$query = 'SELECT * FROM shoes, saledetails, sales WHERE shoes.id=saledetails.id and sales.salesid= saledetails.salesid and sales.startday<=CURRENT_DATE() and sales.endday>CURRENT_DATE() GROUP BY shoes.id ';
	}else{
		$query = 'SELECT * FROM shoes, saledetails, sales WHERE shoes.id=saledetails.id  and sales.salesid= saledetails.salesid and sales.startday<=CURRENT_DATE() and sales.endday>CURRENT_DATE()and saledetails.salesid ='. $saleid.' GROUP BY shoes.id ';
	}


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