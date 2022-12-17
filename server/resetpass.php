<?php
include "connect.php";

if($_GET['key'] && $_GET['reset'])
{
  $usn=$_GET['key'];
  $pass=$_GET['reset'];
  $query= 'SELECT username,password FROM account WHERE username = '.$usn.' AND password ='.$pass.'';
  $data = mysqli_query($conn,$query);

  
  if($data == true)
  {
    ?>
    <form method="post" action="submit_new.php">
    <input type="hidden" name="username" value="<?php echo $usn;?>">
    <p>Enter New password</p>
    <input type="password" name='password'>
    <input type="submit" name="submit_password">
    </form>
    <?php
  }
}
?> 