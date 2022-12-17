<?php
include "connect.php";
$id  = $_POST['id'];
// $accid = $_POST['accountid']; 

$query ='SELECT * FROM `review` LEFT JOIN account ON account.accountid = review.accountid WHERE `id` =  '.$id.'';
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