<?php
  ob_start();
  session_start();
  include "includes/config.php";
  date_default_timezone_set('UTC');
  

  if(isset($_SESSION['sname']) and isset($_SESSION['spass'])){
   header("location: index.html");
   exit();
}
  $username = mysqli_real_escape_string($dbcon, strip_tags($_POST['user']));
  $passnotc = mysqli_real_escape_string($dbcon, strip_tags($_POST['pass']));
  $salt     = 'fs978'; // SALT for encrypting
  $userpass = md5($passnotc . $salt);
  $lvisi = date('Y-m-d');
 $finder = mysqli_query($dbcon, "
  SELECT * FROM users WHERE username='".strtolower($username)."' AND password='".$userpass."'") or die("mysqli error");
  if(mysqli_num_rows($finder) != 0){
    $row = mysqli_fetch_assoc($finder);
    if(strtolower($username) == strtolower($row['username']) and $userpass==$row['password']){
     //$sname = $_SESSION['sname'];
     $_SESSION['sname'] = $username;
     $_SESSION['spass'] = $userpass;
	  $errorbox = "<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><p>Login successful. Redirecting …</p></div>";
      echo '{"state":"1","errorbox":"'.$errorbox.'","url":"index.html"}';
	  }else{
	  $errorbox = "<div class='alert alert-dismissible alert-info'><button type='button' class='close' data-dismiss='alert'>×</button><p>Login failed! Please try again!</p></div>";
      echo '{"state":"0","errorbox":"'.$errorbox.'","url":"0"}';
    }
  }else{
	  $errorbox = "<div class='alert alert-dismissible alert-info'><button type='button' class='close' data-dismiss='alert'>×</button><p>Login failed! Please try again!</p></div>";
      echo '{"state":"0","errorbox":"'.$errorbox.'","url":"0"}';  }
  
  ?>
