<?php
include "connect.php";

$user = "admin";//$_POST['username'];
if($user== "" || $user == null){
    $query ="SELECT * FROM account ";
}else{
    $query ="SELECT * FROM account WHERE username = '$user'";
}

$data = mysqli_query($conn, $query);
$result = array();
while($row = mysqli_fetch_assoc($data)) {
    $result[] = ($row);
}
if (!empty($result)) {
    $arr= [
         
         'result' => $result
         ];
}else{
    $arr = [
        
         'result' => $result
        ];             
}
print_r(json_encode($arr));
?>