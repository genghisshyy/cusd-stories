<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->

  <head>
    <?php include "includes/header-core.php";
      $current_page = "article";
    ?>
  </head>

  <body id="index">
    <!--[if lt IE 7]>
      <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <?php include "includes/navbar.php"; ?>


    <?php include "includes/sidenav.php"; ?>


    <?php
    $key = "5aa6bdf94dfbbc04c97e91c6f493c78a9eb37adf91222";

    function get_info($target, $key){
      $ret = file_get_contents("https://api.linkpreview.net?key={$key}&q={$target}");
      $page_details = json_decode($ret, true);
      return $page_details;
    }

    // $info = get_info("https://medium.com/@cathyliu_55604/how-cusd-has-impacted-you-tony-li-8cf3296fbf5f", $key);

    // $info = get_info("https://medium.com/@cathyliu_55604/how-cusd-has-impacted-you-tony-li-8cf3296fbf5f", $key);

    ?>

     <div class="row center-align main">

      <div id ="main_cards" class="col s12 l4">
    <!-- put the tag here for filter search ^ -->
          <!-- <div class="card-bg ">
            <div class = "col l6 s6 m6 content-tag-div">
                <div class = "about-tag">
                  People
                </div>
                <div class = "type-tag">
                  Articles
                </div>
            </div>
            <div class= "card-img"
                style= "background-image: url('https://cdn-images-1.medium.com/max/1200/1*L0zf9ap8xoInVbm78siJBA.png');">
            </div>

            <div class="card-body">
                <div class = "card-title">
                    Name of Article
                </div>
                <div class = "card-description">
                    Body of Article
                </div>
            </div>
          </div> -->


      </div>

      <!-- <div class="col s12 l4">
        <div class="card-bg">
          <div class= "card-img"
              style= "background-image: url('https://cdn-images-1.medium.com/max/1200/1*L0zf9ap8xoInVbm78siJBA.png');">
          </div>
          <div class="card-body">
            <div class = "card-title">
                Name of Article
            </div>
                Body of Article
          </div>
        </div>
      </div>

      <div class="col s12 l4">
        <div class="card-bg">
          <div class= "card-img"
              style= "background-image: url('https://cdn-images-1.medium.com/max/1200/1*L0zf9ap8xoInVbm78siJBA.png');">
          </div>
          <div class="card-body">
            <div class = "card-title">
              Title of Article
            </div>
              Body of article
          </div>
        </div>
      </div> -->


    </div>




    <?php include "includes/footer.php"; ?>


    <?php include "includes/js-scripts.php"; ?>

    <script> type_controller('<?php echo $current_page?>', 'ALL') </script>


  </body>

</html>
