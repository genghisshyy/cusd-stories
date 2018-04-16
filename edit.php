<?php
include("includes/init.php");
// declare constants
const INPUT_TYPE = ["article", "video"];
const VALID_EXTNS = ["jpg", "jpeg", "png"];
const UPLOAD_PATH = "img/uploads/";
$GLOBALS['messages'] = array();
$upload_submitted = false;

// is valid inputs of form
$is_valid = true;

if (isset($_GET["id"])){
  $id = ($_GET["id"]);
  //echo $id;
  $select_story = "SELECT * From posts2 WHERE id = :id";
  $params = array(
    ':id' => $id
  );

  // connection string for heroku
  $connection_string= "dbname=d9bvjse2g8ba1h host=ec2-54-243-210-70.compute-1.amazonaws.com port=5432 user=dxwirrhzaydomo password=62adc98f8f11caa8d9a71c385d70edb1483dbb761458189b20f5ba9f6ddfae6e sslmode=require";

  // PDO connection using heroku string
  $conn = new PDO ("pgsql:".$connection_string);

  $entry = exec_sql_query($conn, $select_story, $params)->fetchAll();;

  $entry_filepath = $entry[0]["file_path"];

  //echo $entry_tag_2;
  //get just the name of the file to display

}

//update the entry
if (isset($_POST["update_button"])){
  $id = ($_GET["id"]);
  // grab text inputs
  $new_title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
  $new_tag_line = filter_input(INPUT_POST, 'tag_line', FILTER_SANITIZE_STRING);
  $new_url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_URL);
  $new_tag_1 = filter_input(INPUT_POST, 'tag_1', FILTER_SANITIZE_STRING);
  $new_tag_2 = filter_input(INPUT_POST, 'tag_2', FILTER_SANITIZE_STRING);

  // check if tags are the distinct and not null
  if (!($new_tag_1 == $new_tag_2)) {
    if ($new_tag_1 && $new_tag_2) {
      $field_str = "tag_1, tag_2";
      $param_str = ":tag_1, :tag_2";
    } else if ($new_tag_1) {
      $field_str = "tag_1";
      $param_str = ":tag_1";
    } else if ($new_tag_2) {
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
    $new_input_type = filter_input(INPUT_POST, 'input_type', FILTER_SANITIZE_STRING);
  }else{
    $is_valid = false;
  }
  $file = $_FILES["input_photo"];
  if($file['error'] > 0){
    $new_file_path = $entry_filepath;
  }
  else{
    // if move_uploaded_file()
    // grab file data

    $upload_name = basename($file["name"]);
    $upload_ext = strtolower(pathinfo($upload_name, PATHINFO_EXTENSION) );

    // assert valid file extension on backend
    if (!in_array($upload_ext, VALID_EXTNS)){
      $is_valid = false;
    };

    // catenate path for backend database
    $new_file_path = UPLOAD_PATH . $upload_name;

  }

  // check output...
  //var_dump($new_title);
  //var_dump($new_tag_line);
  //var_dump($new_url);
  //var_dump($new_input_type);
  //var_dump($upload_name, $upload_ext);
  //var_dump($new_file_path);
  //var_dump($new_tag_1);
  //var_dump($new_tag_2);

  // connection string for heroku
  $connection_string= "dbname=d9bvjse2g8ba1h host=ec2-54-243-210-70.compute-1.amazonaws.com port=5432 user=dxwirrhzaydomo password=62adc98f8f11caa8d9a71c385d70edb1483dbb761458189b20f5ba9f6ddfae6e sslmode=require";

  // PDO connection using heroku string
  $conn = new PDO ("pgsql:".$connection_string);

  // SQL template
  $update = "UPDATE posts2 SET title = :new_title , tag_line = :new_tag_line, url = :new_url, input_type = :new_input_type, file_path = :new_file_path, tag_1 = :new_tag_1, tag_2 = :new_tag_2  WHERE id= :id ";
  //insert into database
  if ($is_valid){
    // Here, all inputs are valid
     $params = array(
      ":new_title" => $new_title,
      ":new_tag_line" => $new_tag_line,
      ":new_url" => $new_url,
      ":new_input_type" => $new_input_type,
      ":new_file_path" => $new_file_path,
      ":id" => $id,
      ":new_tag_1" => $new_tag_1,
      ":new_tag_2" => $new_tag_2
    );
    //var_dump($update);
    //var_dump($id);
    $updated= exec_sql_query($conn, $update, $params);
    if ($file['error']==0) {
       $ext_str = pathinfo($file['name'], PATHINFO_EXTENSION);
       $ext = filter_var(strtolower($ext_str), FILTER_SANITIZE_STRING);
    if ($updated) {
      //echo "made it in there";
      $insertID = 0;
      $updated =exec_sql_query($conn, $update, $params);
      //var_dump($updated);
      move_uploaded_file($file["tmp_name"], "img/uploads/" . (string) $insertID . "." . $ext);
      $insertID += 1;
    } else {
      record_message("Execution of query failed, check inputs.");
    }

      record_message("Successful Update!");
    } else {
      record_message("Unsuccessful update, check your inputs.");
    }
    } else {
      record_message("Unsuccessful update, check your inputs.");
    }
}
if (isset($_POST["delete_button"])){ //delete the entry
  $id = ($_GET["id"]);
  // connection string for heroku
  $connection_string= "dbname=d9bvjse2g8ba1h host=ec2-54-243-210-70.compute-1.amazonaws.com port=5432 user=dxwirrhzaydomo password=62adc98f8f11caa8d9a71c385d70edb1483dbb761458189b20f5ba9f6ddfae6e sslmode=require";

  // PDO connection using heroku string
  $conn = new PDO ("pgsql:".$connection_string);

  $delete = "DELETE FROM posts2 WHERE id = :id";
  $paramsd = array(
    ":id" => $id
  );
  $deleted = exec_sql_query($conn, $delete, $paramsd);
  if ($deleted){
    header("Location: index.php");
  }
}

if (isset($_GET["id"])){
  $id = ($_GET["id"]);
  //echo $id;
  $select_story = "SELECT * From posts2 WHERE id = :id";
  $params = array(
    ':id' => $id
  );

  // connection string for heroku
  $connection_string= "dbname=d9bvjse2g8ba1h host=ec2-54-243-210-70.compute-1.amazonaws.com port=5432 user=dxwirrhzaydomo password=62adc98f8f11caa8d9a71c385d70edb1483dbb761458189b20f5ba9f6ddfae6e sslmode=require";

  // PDO connection using heroku string
  $conn = new PDO ("pgsql:".$connection_string);

  $entry = exec_sql_query($conn, $select_story, $params)->fetchAll();;
  $entry_title = $entry[0]["title"];
  $entry_tagline = $entry[0]["tag_line"];
  $entry_url = $entry[0]["url"];
  $entry_input = $entry[0]["input_type"];
  $entry_title = $entry[0]["title"];
  $entry_filepath = $entry[0]["file_path"];
  $entry_tag_1 = $entry[0]["tag_1"];
  $entry_tag_2 = $entry[0]["tag_2"];
  //echo $entry_tag_2;
  //get just the name of the file to display
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
  <?php if ($current_user) {?>
     <div class="container">
       <div class="row">
        <h2 class="center-align"> Edit Entry "<?php echo $entry_title;?>"</h2>

        <form method="post" action="edit.php?id=<?php echo $id;?>" enctype="multipart/form-data" id="submission_form">

          <div class="row">

            <!-- left side -->
            <div class="section col s12 l6">
              <h5>Title</h5>
              <input class="col s12" type="text" name="title" value="<?php echo $entry_title;?>">
            </div>

            <div class="section col s12 l6">
              <h5>Tag Line</h5>
              <input class="col s12" type="text" name="tag_line" value="<?php echo $entry_tagline;?>" data-length="80">
            </div>

            <!-- right side -->
            <div class="section col s12 l6">
              <h5>URL</h5>
              <input class="col s12" type="text" name="url" value="<?php echo $entry_url;?>" pattern="https?://.+" title="https or http URLs only">
            </div>

            <div class="section col s12 l6">
              <h5>Video or Article</h5>
              <p>
                <?php if($entry_input == "article"){
                  echo "<input name='input_type' type='radio' id='article' checked = 'checked' value='article'/>";
                }else{
                  echo "<input name='input_type' type='radio' id='article' value='article' />";
                }
                ?>

                <label for="article">Article</label>
                <?php if($entry_input == "video"){
                  echo "<input name='input_type' type='radio' id='video' checked = 'checked' value='article'/>";
                }else{
                  echo "<input name='input_type' type='radio' id='video' value='article' />";
                }
                ?>
                <label for="video">Video</label>
              </p>
            </div>
          </div>
          <div class="section col s12 l6">
            <h5>Tag #1</h5>
            <p><select name="tag_1" form="submission_form">
              <option value=NULL>Select a New Tag</option>
              <?php
              $tag_opts = array("people", "education", "impact", "lifestyle", "events");
              foreach ($tag_opts as $tag) {
                //echo $tag;
                if ($tag == $entry_tag_1){
                  $selected = "selected";
                }else{
                  $selected = "";
                }
                 echo "<option value=$tag $selected>".ucfirst($tag)."</option>";
              }
              ?></select></p>
          </div>
            <div class="section col s12 l6">
              <h5>Tag #2</h5>
              <p><select name="tag_2" form="submission_form">
                <option value=NULL > Select a New Tag</option>
                <?php
                $tag_opts = array("people", "education", "impact", "lifestyle", "events");
                foreach ($tag_opts as $tag) {
                  //echo $tag;
                  if ($tag == $entry_tag_2){
                    $selected = "selected";
                  }else{
                    $selected = "";
                  }
                   echo "<option value=$tag $selected>".ucfirst($tag)."</option>";
                }
                ?></select></p>
          </div>
          <!--<div class="row">-->
          <div class="row">
          <div class="col s12 l6">
            <div class="file-field btn">
              <span>Upload New File</span>
                <input type="file" name= "input_photo" id="entry_file" accept="image/*" onchange="readURL(this)">
            </div>
          </div>
          <div class="col s12 l6">
            <?php echo "<img src =\"". $entry_filepath . "\" id='entry_photo'>";?>
          </div>
        </div>
          <div class ="row">
            <div class="col s12 l6">
                <input type="submit" class= "btn" name="delete_button" value = "Delete" id= "del_button">
            </div>
            <div class="col s12 l6" id="submit_btn">
                <input type="submit" class= "btn" name="update_button" value= "Update">
            </div>
        </div>
      </div>
      <?php } else{ ?>
        <div class="section col s12 l12 center-align">
          <h5>You need to login to view this page</h5>
        </div>
      <?php }  ?>
    </div>




  <?php include "includes/footer.php"; ?>


        <?php include "includes/js-scripts.php"; ?>
