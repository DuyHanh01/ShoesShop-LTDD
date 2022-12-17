<?php
include "connect.php";
$salesid = $_POST['salesid'];
$query ='SELECT d.id ,name, images, salesprice, s.price FROM `saledetails` d, shoes s WHERE d.id = s.id AND salesid = '.$salesid.'';
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