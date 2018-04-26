<?php
// this is the core template for the aritcle and video page,
// php doesnt have templates :'(
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
  <head>
    <?php include "includes/header-core.php"; ?>
  </head>

  <body id="index">
    <!--[if lt IE 7]>
      <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <?php include "includes/navbar.php"; ?>
    <?php include "includes/sidenav.php"; ?>
    <div class="row center-align main large-correction"> </div>
    <?php include "includes/footer.php"; ?>
    <?php include "includes/js-scripts.php"; ?>
    <script> type_controller('<?php echo $current_page?>', 'ALL') </script>
  </body>
</html>
