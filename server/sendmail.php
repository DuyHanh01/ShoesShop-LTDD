<?php
 include "connect.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer/src/Exception.php';
require 'PHPMailer/PHPMailer/src/PHPMailer.php';
require 'PHPMailer/PHPMailer/src/SMTP.php';


$email = $_POST['username'];

$query = "SELECT * FROM account WHERE username = '$email'";
$data = mysqli_query($conn, $query);
$result = array();
while ($row = mysqli_fetch_assoc($data)) {
	$result[] = ($row);

}
	if(empty($result)){
		$arr = [
			'success' => false,
			'message' => " Mail không đúng",
			'result'=> $result
		];
	}else{
		//send mail
	  	$email = ($result[0]['username']);
      	$pass = ($result[0]['password']);
		$link="<a href='http://192.168.1.10:8080/server/reset.php?key=".$email."&reset=".$pass."'>Click To Reset password</a>";
    	$mail = new PHPMailer();
    	$mail->CharSet =  "utf-8";
    	// enable SMTP authentication
    	$mail->SMTPAuth = true;  
    	$mail->isSMTP();                
    	// GMAIL username
    	$mail->username = "4000mneh@gmail.com";
    	// GMAIL password
    	$mail->password = "123";
    	$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  
    	// sets GMAIL as the SMTP server
    	$mail->Host = "smtp.gmail.com";
    	// set the SMTP port for the GMAIL server

    	$mail->Port = "465";
    	$mail->From= "4000mneh@gmail.com";
    	$mail->FromName='App ban giay';
    	$mail->AddAddress($email, 'reciever_name');
    	$mail->Subject  =  'Reset Password';
    	$mail->IsHTML(true);
    	$mail->Body    = $link;
    	if($mail->Send())
    	{
     	 echo "Check Your Email and Click on the link sent to your email";
    	}
    	else
    	{
      	echo "Mail Error - >".$mail->ErrorInfo;
    	}
	}
	print_r($arr);
  
  	
?>