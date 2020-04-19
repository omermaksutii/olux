<?php
ob_start();
session_start();
include "../includes/config.php";


?>

<!DOCTYPE html>
<html>

<head>
    <!-- Bootstrap -->
<script src='https://www.google.com/recaptcha/api.js'></script>

  <meta charset="UTF-8">
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>JeruxShop - Admin Login</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/iconfonts/simple-line-icon/css/simple-line-icons.css">
  <link rel="stylesheet" href="vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.addons.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../css/style.css">
  <!-- endinject -->
</head>

<body><form method="post" action="">
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
        <div class="row w-100 mx-auto">
          <div class="col-lg-4 mx-auto">
            <div class="auto-form-wrapper">
                <div class="form-group">
                  <label class="label">Username</label>
                  <div class="input-group">
                    <input type="text" name="user" class="form-control" placeholder="Username">
                    <div class="input-group-append">
                      <span class="input-group-text"><i class="icon-check"></i></span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="label">Password</label>
                  <div class="input-group">
                    <input type="password" name="pass" class="form-control" placeholder="*********">
                    <div class="input-group-append">
                      <span class="input-group-text"><i class="icon-check"></i></span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <input type="submit" class="btn btn-primary submit-btn btn-block"/> 
                <input type="hidden" name="log" value="in" />

                </div>
          
       
                
              </form>
            </div>

          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <script src="vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="buyer/js/template.js"></script>
  <!-- endinject -->
</body>

</html>
            <?php


if(isset($_POST['log']) and  $_POST['log'] == "in"){
  $user = mysqli_real_escape_string($dbcon, $_POST['user']);
  $pasa = mysqli_real_escape_string($dbcon, $_POST['pass']);
  $pass = md5($pasa);

  $q = mysqli_query($dbcon, "SELECT * FROM manager WHERE username='$user' AND password='$pass'");
  echo mysqli_num_rows($q);
  $row = mysqli_fetch_assoc($q);
  if($user == $row['username'] And $pass == $row['password']){
    $_SESSION['aname'] = $user;
    $_SESSION['apass'] = $pass;
    header("location: index.php");
  }
}


            ?>
