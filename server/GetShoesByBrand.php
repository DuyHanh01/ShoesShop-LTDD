
<?php
include "connect.php";
$brandid = $_POST['brandid'];
if($brandid==0){
	$query = 'SELECT shoes.*,sales.percent, saledetails.salesprice , sales.startday, sales.endday from shoes LEFT JOIN saledetails ON shoes.id = saledetails.id LEFT JOIN sales on sales.salesid=saledetails.salesid  GROUP BY shoes.id ORDER BY shoes.price DESC';		
	}else{
		$query = 'SELECT shoes.*,sales.percent, saledetails.salesprice , sales.startday, sales.endday from shoes LEFT JOIN saledetails ON shoes.id = saledetails.id LEFT JOIN sales on sales.salesid=saledetails.salesid WHERE shoes.brandid= '.$brandid.' GROUP BY shoes.id ORDER BY shoes.price DESC';
	}
//  	';
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