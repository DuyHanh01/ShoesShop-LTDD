<?php
include "connect.php";

$query ="SELECT id FROM shoes WHERE NOT EXISTS (SELECT id FROM saledetails WHERE shoes.id = saledetails.id)";
$data = mysqli_query($conn, $query);
$result = array();
$temp = array();
while($row = mysqli_fetch_assoc($data)) {
    $temp[] = ($row);
}
if(!empty($temp)){
    foreach ($temp as $key => $value) {
        $query = 'SELECT id, images, price, name FROM shoes WHERE id = '.$value["id"].'';
        $data = mysqli_query($conn,$query);
        while($row = mysqli_fetch_assoc($data)) {
            $result[] = ($row);
        }
    }
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