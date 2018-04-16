<?php
include("includes/init.php");

// declare the current location, utilized in header.php
$current_page_id="logout";

log_out();
if (!$current_user) {
  record_message("You've been successfully logged out.");
}
?>
<!DOCTYPE html>
<html class="no-js"> <!--<![endif]-->

  <head>
    <?php include "includes/header-core.php"; ?>
  </head>

  <body id="index">
    <!--[if lt IE 7]>
      <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <?php include "includes/navbar.php"; ?>
  <div class="center-align"id="content-wrap">

    <h1>Log Out</h1>

    <?php
    print_messages();
    ?>
  </div>

  <?php include("includes/footer.php");?>
  <?php include "includes/js-scripts.php"; ?>
</body>

</html>
