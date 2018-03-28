<?php

// declare constants
const INPUT_TYPE = ["article", "video"];
const VALID_EXTNS = ["jpg", "jpeg", "png"];
const UPLOAD_PATH = "img/uploads/";

// is valid inputs of form
$is_valid = true;

// execute query or fail with PDO exception
function exec_sql_query($db, $sql, $params = array()) {
  try {
    $query = $db->prepare($sql);
    if ($query and $query->execute($params)) {
      return $query;
    }
  } catch (PDOException $exception) {
    handle_db_error($exception);
  }
  return NULL;
};

if (isset($_POST["submit_button"])){

  // grab text inputs
  $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
  $tag_line = filter_input(INPUT_POST, 'tag_line', FILTER_SANITIZE_STRING);
  $url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_URL);

  // only can be 'article' or 'video'
  if (in_array(filter_input(INPUT_POST, 'input_type', FILTER_SANITIZE_STRING), INPUT_TYPE)){
    $input_type = filter_input(INPUT_POST, 'input_type', FILTER_SANITIZE_STRING);
  }else{
    $is_valid = false;
  }

  // grab file data
  $file = $_FILES["input_photo"];
  $upload_name = basename($file["name"]);
  $upload_ext = strtolower(pathinfo($upload_name, PATHINFO_EXTENSION) );

  // assert valid file extension on backend
  if (!in_array($upload_ext, VALID_EXTNS)){
    $is_valid = false;
  };

  // catenate path for backend database
  $file_path = UPLOAD_PATH . $upload_name;

  // check output...
  var_dump($title);
  var_dump($tag_line);
  var_dump($url);
  var_dump($input_type);
  var_dump($upload_name, $upload_ext);
  var_dump($file_path);

  // connection string for heroku
  $connection_string= "dbname=d9bvjse2g8ba1h host=ec2-54-243-210-70.compute-1.amazonaws.com port=5432 user=dxwirrhzaydomo password=62adc98f8f11caa8d9a71c385d70edb1483dbb761458189b20f5ba9f6ddfae6e sslmode=require";

  // PDO connection using heroku string
  $conn = new PDO ("pgsql:".$connection_string);

  // SQL template
  $insertion_query = "INSERT INTO posts (title, tag_line, url, input_type, file_path) VALUES (:title, :tag_line, :url, :input_type, :file_path)";

  //insert into database
  if ($is_valid){
    // Here, all inputs are valid
     $params = array(
      ":title" => $title,
      ":tag_line" => $tag_line,
      ":url" => $url,
      ":input_type" => $input_type,
      ":file_path" => $file_path
    );
    exec_sql_query($conn, $insertion_query, $params);

    //TODO: MOVE UPLOADED FILE TO 'img/uploads' folder on successful input into database

    echo "Successful Upload!";
  }
  else{
    echo "Unsuccessful upload, check your inputs";
  };
};
function print_story($story) {
  ?>
  <tr>
    <td><?php echo htmlspecialchars($story["title"]);?></td>
    <td>
      <?php echo htmlspecialchars($story["tag"]);?>
    </td>
    <td><?php echo htmlspecialchars($story["url"]);?></td>
    <td><?php echo "<img src =\"". ($story["file_path"]). "\">";?></td>
  </tr>
  <?php
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

        <form method="post" action="form.php" enctype="multipart/form-data" id="submission_form">

          <div class="row">

            <!-- left side -->
            <div class="section col s12 l6">
              <h5>Title</h5>
              <input class="col s12" type="text" name="title">
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
              <h5>Video or Article</h5>
              <p>
                <input name="input_type" type="radio" id="article" value="article" />
                <label for="article">Article</label>
                <input name="input_type" type="radio" id="video" value="video" />
                <label for="video">Video</label>
              </p>
            </div>
          </div>

          <div class="col s12 l6">
            <div class="btn">
              <input type="file" name= "input_photo" id="input_photo" accept="image/*">
            </div>
          </div>
          <div class="col s12 l6">
            <input type="submit" class= "btn" name="submit_button">
          </div>



        </form>
       </div> <!-- close row -->
       <div class="row">
         <h2 class="center-align"> Edit an Existing Story</h2>
         <
         <?php
            $connection_string= "dbname=d9bvjse2g8ba1h host=ec2-54-243-210-70.compute-1.amazonaws.com port=5432 user=dxwirrhzaydomo password=62adc98f8f11caa8d9a71c385d70edb1483dbb761458189b20f5ba9f6ddfae6e sslmode=require";

            // PDO connection using heroku string
            $conn = new PDO ("pgsql:".$connection_string);

            $select_all = "SELECT * From posts";
            $params = array(
            );
            $stories = exec_sql_query($conn, $select_all, $params)->fetchAll();;
            if (isset($stories) and !empty($stories)) {
        ?>
            <table>
              <tr>
                <th>Title</th>
                <th>Tag</th>
                <th>URL</th>
                <th>Image</th>
              </tr>
              <?php

                foreach($stories as $story) {
                  print_story($story);
                }
              ?>
              </table>
              <?php
            } else {
              echo "<p>No stories.</p>";
            }
            ?>


      </div>

    </div> <!--close container -->


    <?php include "includes/footer.php"; ?>


    <?php include "includes/js-scripts.php"; ?>


  </body>

</html>
