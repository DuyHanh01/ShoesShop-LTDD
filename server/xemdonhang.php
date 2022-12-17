<?php
include "connect.php";
$accountid = $_POST['accountid'];
$query ="SELECT * FROM `order` o, status s WHERE o.statusid = s.statusid and accountid = '$accountid' ORDER BY orderid DESC";
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