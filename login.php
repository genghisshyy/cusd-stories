<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<?php
include("includes/init.php");

// declare the current location, utilized in header.php
//$current_page_id="logout";
if ((isset($_POST["logout"]))){
  log_out();
}

if (!$current_user) {
  record_message("You've been successfully logged out.");
}
?>
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->

  <head>
    <?php
    //echo password_hash("gogreenmodo",PASSWORD_DEFAULT);
    include "includes/header-core.php";
    ?>
  </head>

  <body id="index">
    <!--[if lt IE 7]>
      <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <?php print_messages(); ?>
    <?php include "includes/navbar.php"; ?>
    <div class="container">
      <div class="row">
    <?php if (!$current_user) { ?>
        <h2 class="center-align"> Login</h2>
        <form method="post" action="login.php" enctype="multipart/form-data" id="submission_form">

            <div class="input-field col s6 offset-s3 ">
                <h5>Username:</h5>
              <input type="text" name="username" required/>
            </div>
            <div class="input-field col s6 offset-s3 ">
              <h5>Password:</h5>
              <input type="password" name="password" required/>
            </div>
            <div class="col s12 center-align">
              <input type="submit" class= "btn" name="login" value="Login">
            </div>

        </form>
        <?php } ?>
       <?php if ($current_user) { ?>
         <h2 class="center-align"> Logout</h2>
         <form method="post" action="login.php" enctype="multipart/form-data" id="submission_form">
           <div class="col s12 center-align">
             <input type="submit" class= "btn" name="logout" value="Logout">
           </div>
        </form>
        <?php } ?>
      </div>
    </div> <!--close container -->

      <?php include "includes/footer.php"; ?>


      <?php include "includes/js-scripts.php"; ?>


    </body>

  </html>
