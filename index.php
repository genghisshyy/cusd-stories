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

    <?php
    $key = "5aa6bdf94dfbbc04c97e91c6f493c78a9eb37adf91222";

    function get_info($target, $key){
      $ret = file_get_contents("https://api.linkpreview.net?key={$key}&q={$target}");
      $page_details = json_decode($ret, true);
      return $page_details;
    }
    ?>

     <div class="row center-align">

     <?php include "includes/allLoad.php"; ?>

      </div>




    <?php include "includes/footer.php"; ?>


    <?php include "includes/js-scripts.php"; ?>


  </body>

</html>
