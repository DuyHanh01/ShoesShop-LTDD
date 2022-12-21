<?php
include "connect.php";

$user = $_POST['username'];
$pass = $_POST['password'];



$query = "UPDATE `account` SET `password`='$pass' WHERE username = '$user'";

$data = mysqli_query($conn, $query);
  if ($data == true) {
    $arr = [
      'success' => true,
      'message'=> "thanh cong",
      'result'=> []
    ];
  }else{
    $arr = [
      'success' => false,
      'message' => " khong thanh cong",
      'result'=> []
    ];
  } 

print_r(json_encode($arr));
?> 