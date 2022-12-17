<?php
 require "connect.php";


$pass = md5($_POST['oldpassword']);
$newpass = md5($_POST['newpassword']);
$usn = $_POST['username'];

$query = "SELECT * FROM account WHERE password = '$pass' and username = '$usn'";
$data = mysqli_query($conn, $query);
$result = array();
while ($row = mysqli_fetch_assoc($data)) {
  $result[] = ($row);
  // code...
}
  if (mysqli_num_rows($data) <= 0){
    $arr = [
    'success' => false,
    'message'=> "Mật khẩu cũ không tìm thấy",
    'result' => $result
  ];
  }else{
    $update = "UPDATE account Set password = '$newpass' Where username = '$usn'";
    $res = mysqli_query($conn, $update);
    if($res){
      $arr = [
        'success' => true,
        'message'=> "Thay đổi mật khẩu thành công",
        'result' => $result
        ];
    }else{
      $arr = [
        'success' => false,
        'message'=> "Thay đổi mật khẩu thất bại",
        'result' => $result
        ];
    }
  }
print_r(json_encode($arr));







 
?>