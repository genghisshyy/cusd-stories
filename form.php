<?php
const INPUT_TYPE = ["article", "video"];
const UPLOAD_PATH = "img/uploads/";

if (isset($_POST["submit_button"])){
  $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
  $tag_line = filter_input(INPUT_POST, 'tag_line', FILTER_SANITIZE_STRING);
  $url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_URL);
  
  // only can be 'article' or 'video'
  if (in_array(filter_input(INPUT_POST, 'input_type', FILTER_SANITIZE_STRING), INPUT_TYPE)){
    $input_type = filter_input(INPUT_POST, 'input_type', FILTER_SANITIZE_STRING);
  };


  $file = $_FILES["input_photo"];

  $upload_name = basename($file["name"]);
  $upload_ext = strtolower(pathinfo($upload_name, PATHINFO_EXTENSION) );
  
  var_dump($title);
  var_dump($tag_line);
  var_dump($url);
  var_dump($input_type);
  var_dump($upload_name, $upload_ext);
}



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

     <div class="container">
       <div class="row">
        <h2 class="center-align"> Enter a New Story</h2>

        <form method="post" action="form.php" enctype="multipart/form-data">

          <div class="row">

            <!-- left side -->
            <div class="section col s12 l6">
              <h5>Title</h5>
              <input class="col s12" type="text" name="title" pattern="^[0-9a-zA-Z \b]+$" title="No Special Characters allowed">
            </div>

            <div class="section col s12 l6">
              <h5>Tag Line</h5>
              <input class="col s12" type="text" name="tag_line" data-length="120">
            </div>
          
            <!-- right side -->
            <div class="section col s12 l6">
              <h5>URL</h5>
              <input class="col s12" type="text" name="url" pattern="https?://.+" title="https or http URLs only">
            </div>

            <div class="section col s12 l6">
              <h5>Section 4</h5>
              <p>
                <input name="input_type" type="radio" id="article" value="article" />
                <label for="article">Article</label>
                <input name="input_type" type="radio" id="video" value="video" />
                <label for="video">Video</label>
              </p>
            </div>
          </div>

          <div class="col s12">
            <div class="file-field input-field">
              <div class="btn">
                <span>Image</span>
                <input type="file" name= "input_photo">
              </div>
            </div>
          </div>


          

          <div class="col s12 center-align">
            <input type="submit" class= "btn" name="submit_button">
          </div>
         
        
        
        </form> 
       </div> <!-- close row --> 
    </div> <!--close container -->


    <?php include "includes/footer.php"; ?>


    <?php include "includes/js-scripts.php"; ?>


  </body>

</html>
