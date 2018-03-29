<?php

// declare constants
const INPUT_TYPE = ["article", "video"];
const VALID_EXTNS = ["jpg", "jpeg", "png"];
const UPLOAD_PATH = "img/uploads/";
$GLOBALS['messages'] = array();
$upload_submitted = false;

// is valid inputs of form
$is_valid = true;

// execute query or fail with PDO exception
function exec_sql_query($db, $sql, $params = array()) {
  try {
    var_dump($db);
    $query = $db->prepare($sql);
    if ($query and $query->execute($params)) {
      return $query;
    }
  } catch (PDOException $exception) {
    handle_db_error($exception);
  }
  return NULL;
};

// Record a message to display to the user.
function record_message($message) {
  global $messages;
  array_push($messages, $message);
};

// Print messages to user.
function print_messages() {
  global $messages;
  foreach ($messages as $message) {
    echo htmlspecialchars($message);
  }
};

if (isset($_POST["submit_button"])){

  // grab text inputs
  $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
  $tag_line = filter_input(INPUT_POST, 'tag_line', FILTER_SANITIZE_STRING);
  $url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_URL);
  $tag_1 = filter_input(INPUT_POST, 'tag_1', FILTER_SANITIZE_STRING);
  $tag_2 = filter_input(INPUT_POST, 'tag_2', FILTER_SANITIZE_STRING);

  // check if tags are the distinct and not null
  if (!($tag_1 == $tag_2)) {
    if ($tag_1 && $tag_2) {
      $field_str = "tag_1, tag_2";
      $param_str = ":tag_1, :tag_2";
    } else if ($tag_1) {
      $field_str = "tag_1";
      $param_str = ":tag_1";
    } else if ($tag_2) {
      $field_str = "tag_2";
      $param_str = ":tag_2";
    } else {
      $is_valid = false;
    }
  } else {
    $is_valid = false;
    record_message("Tag can only be selected once. ");
  }

  // only can be 'article' or 'video'
  if (in_array(filter_input(INPUT_POST, 'input_type', FILTER_SANITIZE_STRING), INPUT_TYPE)){
    $input_type = filter_input(INPUT_POST, 'input_type', FILTER_SANITIZE_STRING);
  } else {
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
  var_dump($tag_1);
  var_dump($tag_2);
  var_dump($url);
  var_dump($input_type);
  var_dump($upload_name, $upload_ext);
  var_dump($file_path);

  // connection string for heroku
  $connection_string= "dbname=d9bvjse2g8ba1h host=ec2-54-243-210-70.compute-1.amazonaws.com port=5432 user=dxwirrhzaydomo password=62adc98f8f11caa8d9a71c385d70edb1483dbb761458189b20f5ba9f6ddfae6e sslmode=require";

  // PDO connection using heroku string
  $conn = new PDO ("pgsql:".$connection_string);

 if ($is_valid) {
  $insertion_query = "INSERT INTO posts2 (title, tag_line, url, input_type, file_path, $field_str) VALUES (:title, :tag_line, :url, :input_type, :file_path, $param_str)";
  $params = array(
   ":title" => $title,
   ":tag_line" => $tag_line,
   ":url" => $url,
   ":input_type" => $input_type,
   ":file_path" => $file_path,
 );

if ($field_str == "tag_1, tag_2") {
  $params["tag_1"] = $tag_1;
  $params["tag_2"] = $tag_2;
} else if ($field_str == "tag_1") {
   $params["tag_1"] = $tag_1;
 } else if ($field_str == "tag_2") {
   $params["tag_2"] = $tag_2;
 } else {
    record_message("Tag values are invalid, check inputs. ");
 }

 if ($file['error']==0) {
   $ext_str = pathinfo($file['name'], PATHINFO_EXTENSION);
   $ext = filter_var(strtolower($ext_str), FILTER_SANITIZE_STRING);
if (exec_sql_query($conn, $insertion_query, $params)) {
  $insertID = 0;
  exec_sql_query($conn, $insertion_query, $params);
  move_uploaded_file($file["tmp_name"], "img/uploads/" . (string) $insertID . "." . $ext);
  $insertID += 1;
} else {
  record_message("Execution of query failed, check inputs.");
}

  record_message("Successful Upload!");
} else {
  record_message("Unsuccessful upload, check your inputs.");
}
} else {
  record_message("Unsuccessful upload, check your inputs.");
}
    //TODO: MOVE UPLOADED FILE TO 'img/uploads' folder on successful input into database

  };
function print_story($story) {
  ?>
  <tr>
    <td><?php echo htmlspecialchars($story["title"]);?></td>
    <td>
      <?php echo htmlspecialchars($story["tag_line"]);?>
    </td>
    <td><?php echo htmlspecialchars($story["url"]);?></td>
    <td><?php echo "<img src =\"". ($story["file_path"]). "\">";?></td>
    <td><?php echo htmlspecialchars($story["tag_1"]);?></td>
    <td><?php echo htmlspecialchars($story["tag_2"]);?></td>
    <td><?php echo "<a href=\"". "/edit.php?id=". $story["id"] . "\"> <button class='btn' type='submit' action='edit.php'> Edit </button></a>";?></td>
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

            <div class="section col s12 l6">
              <h5>Video or Article</h5>
              <p>
                <input name="input_type" type="radio" id="article" value="article" />
                <label for="article">Article</label>
                <input name="input_type" type="radio" id="video" value="video" />
                <label for="video">Video</label>
              </p>
            </div>

            <!-- right side -->
            <div class="section col s12 l6">
              <h5>URL</h5]>
              <input class="col s12" type="text" name="url" pattern="https?://.+" title="https or http URLs only">
            </div>

            <div class="section col s12 l6">
              <h5>Tag #1</h5>
              <p><select name="tag_1" form="submission_form">
                <option value=NULL selected disabled>Select a Tag</option>
                <?php
                $tag_opts = array("people", "education", "impact", "lifestyle", "events");
                foreach ($tag_opts as $tag) {
                  echo "<option value=$tag>".ucfirst($tag)."</option>";
                }
                ?></select></p>
            </div>
              <div class="section col s12 l6">
                <h5>Tag #2</h5>
                <p><select name="tag_2" form="submission_form">
                  <option value=NULL selected>Select a Tag</option>
                  <?php
                  $tag_opts = array("people", "education", "impact", "lifestyle", "events");
                  foreach ($tag_opts as $tag) {
                    echo "<option value=$tag>".ucfirst($tag)."</option>";
                  }
                  ?></select></p>
            </div>

          <div class="col s12 l6 center-align">
            <div class="file-field btn" id="file_">
                <span>Upload File</span>
                <input type="file" name= "input_photo" id="input_photo" accept="image/*">
              </div>
          </div>

          <div class="col s12 l6 center-align">
            <input type="submit" class= "btn" name="submit_button">
          </div>
<?php print_messages(); ?>

        </form>
       </div> <!-- close row -->
       <div class="row">
         <h2 class="center-align"> Edit an Existing Story</h2>
         <?php
            $connection_string= "dbname=d9bvjse2g8ba1h host=ec2-54-243-210-70.compute-1.amazonaws.com port=5432 user=dxwirrhzaydomo password=62adc98f8f11caa8d9a71c385d70edb1483dbb761458189b20f5ba9f6ddfae6e sslmode=require";

            // PDO connection using heroku string
            $conn = new PDO ("pgsql:".$connection_string);

            $select_all = "SELECT * From posts2";
            $params = array(
            );
            $stories = exec_sql_query($conn, $select_all, $params)->fetchAll();;
            if (isset($stories) and !empty($stories)) {
        ?>
            <table>
              <thead>
                <th>Title</th>
                <th>Tagline</th>
                <th>URL</th>
                <th>Image</th>
                <th>Tag 1</th>
                <th>Tag 2</th>
              </thead>
              <tbody>
              <?php
                foreach($stories as $story) {
                  print_story($story);
                }
              ?>
            </tbody>
              </table>
              <?php
            }else{
              echo "<p>No stories.</p>";
            }
            ?>


      </div>

    </div> <!--close container -->

    <?php include "includes/footer.php"; ?>


    <?php include "includes/js-scripts.php"; ?>


  </body>

</html>
