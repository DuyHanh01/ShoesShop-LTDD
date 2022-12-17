<?php
include "connect.php";

$query = 'SELECT shoes.*,sales.percent, saledetails.salesprice, sales.startday, sales.endday from shoes LEFT JOIN saledetails ON shoes.id = saledetails.id LEFT JOIN sales on sales.salesid=saledetails.salesid WHERE shoes.shoesnew= true GROUP BY shoes.id';

//$query ="SELECT * FROM shoes ORDER BY id DESC";
$data = mysqli_query($conn, $query);
$result = array();
while($row = mysqli_fetch_assoc($data)) {
    $result[] = ($row);
}
if (!empty($result)) {
    $arr= [
         'success' => true,
         'message' => "thanh cong",
         'result' => $result
         ];
}else{
    $arr = [
        'success' => false,
         'message' =>"khong thanh cong",
         'result' => $result
        ];             
}
print_r(json_encode($arr));
?>