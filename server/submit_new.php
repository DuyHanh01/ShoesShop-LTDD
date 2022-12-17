<?php
include "connect.php";
if(isset($_POST['submit_password']) && $_POST['username'] )
{
  $usn=$_POST['username'];
  $pass=$_POST['password'];

  $query= "update account set password='$pass' where username='$usn'";
  $data = mysqli_query($conn,$query);
  if($data == true)
  {
    echo "Success";
  }


}
?>