<?php
  // main landing page, allLoad.php just kicks out the entire database
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
  <head>
    <?php include "includes/header-core.php";
     $current_page = "index";
    ?>
  </head>

  <body id="index">
    <!--[if lt IE 7]>
      <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <?php include "includes/navbar.php"; ?>
    <div class ="row center-align welcome">
      <h2> What do our members do? </h2>
      <p> A place to see what the members of CUSD do in their academic and professional lives </p>
    </div>
    <div class="row center-align">
       <?php include "includes/allLoad.php"; ?>
    </div>
    <?php include "includes/footer.php"; ?>
    <?php include "includes/js-scripts.php"; ?>
  </body>

</html>
