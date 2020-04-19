<?php
  ob_start();
  session_start();
  include "includes/config.php";
  date_default_timezone_set('UTC');


  if(isset($_SESSION['sname']) and isset($_SESSION['spass'])){
   header("location: index.html");
   exit();
}

$uname = mysqli_real_escape_string($dbcon, strip_tags($_POST['username']));
$email = mysqli_real_escape_string($dbcon, strip_tags($_POST['email']));
$pass1 = mysqli_real_escape_string($dbcon, strip_tags($_POST['password_signup']));
$pass2 = mysqli_real_escape_string($dbcon, strip_tags($_POST['password_signup2']));
$ip    = getenv("REMOTE_ADDR");
$rdate = date("y-m-d");
$lvisi = date('y-m-d');

$passstrlen = strlen($pass1);

$result = mysqli_query($dbcon, "SELECT * FROM users WHERE username='".$uname."'");
	$userexist = mysqli_num_rows($result);

$result = mysqli_query($dbcon, "SELECT * FROM users WHERE email='".$email."'");
	$emailexist = mysqli_num_rows($result);



  if(empty($uname) or empty($email) or empty($pass1) or empty($pass2)){
	  $errorbox = "<div class='alert alert-dismissible alert-info'><button type='button' class='close' data-dismiss='alert'>×</button><p>Please check all entries</p></div>";
      echo '{"state":"0","errorbox":"'.$errorbox.'","url":""}';
  }elseif(strlen($uname) > 16){
	  $errorbox = "<div class='alert alert-dismissible alert-info'><button type='button' class='close' data-dismiss='alert'>×</button><p>Username must be less than 16 chars.</p></div>";
      echo '{"state":"0","errorbox":"'.$errorbox.'","url":""}';
  }elseif($userexist == 1 || $uname == "NONE" || $uname == "NULL" || $uname == "SYSTEM" || $uname == "none" || $uname == "system"){
	  $errorbox = "<div class='alert alert-dismissible alert-info'><button type='button' class='close' data-dismiss='alert'>×</button><p>Username already exists!</p></div>";
      echo '{"state":"0","errorbox":"'.$errorbox.'","url":""}';
  }elseif($emailexist == 1){
	  $errorbox = "<div class='alert alert-dismissible alert-info'><button type='button' class='close' data-dismiss='alert'>×</button><p>Email already exists!</p></div>";
      echo '{"state":"0","errorbox":"'.$errorbox.'","url":""}';
  }elseif($pass1 != $pass2){
	  $errorbox = "<div class='alert alert-dismissible alert-info'><button type='button' class='close' data-dismiss='alert'>×</button><p>Passwords do not match!</p></div>";
      echo '{"state":"0","errorbox":"'.$errorbox.'","url":""}';
  }elseif($passstrlen <6 or $passstrlen > 16){
	  $errorbox = "<div class='alert alert-dismissible alert-info'><button type='button' class='close' data-dismiss='alert'>×</button><p>Password must be more than 6 and less than 16.</p></div>";
      echo '{"state":"0","errorbox":"'.$errorbox.'","url":""}';
  }elseif(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i",$email)){
	  $errorbox = "<div class='alert alert-dismissible alert-info'><button type='button' class='close' data-dismiss='alert'>×</button><p>Invalid email!</p></div>";
      echo '{"state":"0","errorbox":"'.$errorbox.'","url":""}';
  }else{
    $salt = 'fs978'; // SALT for encrypting
    $password = md5($pass1 . $salt);

   $insert = mysqli_query($dbcon, "INSERT INTO users
   (username,password,email,balance,ipurchassed,ip,lastlogin,datereg,resseller,img,testemail,resetpin)
   VALUES
   ('$uname','$password','$email','0','0','$ip','$lvisi','$rdate','0','','$email','')") or die(mysqli_error($dbcon));
 
	  $errorbox = "<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><p>Successfull .. Redirecting</p></div>";
      echo '{"state":"1","errorbox":"'.$errorbox.'","url":"login.html"}';
      
  }


mysqli_close($dbcon);
ob_end_flush();
?>
