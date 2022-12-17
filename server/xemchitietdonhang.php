<?php
include "connect.php";
$iddh = $_POST['orderid'];
$query ="SELECT o.id,o.price, s.images, o.size, o.quantity, s.name,d.statusid FROM orderdetails o, shoes s, `order` d WHERE o.id = s.id AND o.orderid = d.orderid AND o.orderid = $iddh";
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