<?php
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

     <div class="container">
       <div class="row">
        <h2 class="center-align"> Edit Entry "<?php echo $entry_title;?>"</h2>

        <form method="post" action="form.php" enctype="multipart/form-data" id="submission_form">

          <div class="row">

            <!-- left side -->
            <div class="section col s12 l6">
              <h5>Title</h5>
              <input class="col s12" type="text" name="title" value="<?php echo $entry_title;?>">
            </div>

            <div class="section col s12 l6">
              <h5>Tag Line</h5>
              <input class="col s12" type="text" name="tag_line" value="<?php echo $entry_tagline;?>" data-length="120">
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

          <!--<div class="row">-->

              <div class="file-field input-field">
                <div class="btn">
                  <span>File</span>
                  <input type="file"name= "input_photo" id="input_photo" accept="image/*">
                </div>
                <div class="file-path-wrapper">
                  <input class="file-path validate" type="text" placeholder="<?php echo $entry_filepath;?>>
                </div>
              </div>

            <div class="col s12 l6" id="submit_btn">
              <input type="submit" class= "btn" name="submit_button">
            </div>
          <div class="col s12 l6">
            <span>Delete Entry</span>
            <input type="submit" class= "btn" name="delete_button">
          </div>
      
