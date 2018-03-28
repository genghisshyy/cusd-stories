<?php
include "js-scripts.php";

// connection string for heroku
$connection_string= "dbname=d9bvjse2g8ba1h host=ec2-54-243-210-70.compute-1.amazonaws.com port=5432 user=dxwirrhzaydomo password=62adc98f8f11caa8d9a71c385d70edb1483dbb761458189b20f5ba9f6ddfae6e sslmode=require";
$connected = 0;
// PDO connection using heroku string
try
{
  // PDO connection using heroku string
  $conn = new PDO ("pgsql:".$connection_string);
  echo "Connected<p>";
  $table = $conn->query('SELECT * FROM posts2');
  $connected = 1;
}
catch (Exception $e)
{
  echo "Unable to connect: " . $e->getMessage() ."<p>";
}


if ($connected){
foreach ($table as $row){?>

<div class="col s12 l4 filterDiv <?php echo $row['tag_1'] ?> ">
<!-- put the tag here for filter search ^ -->
      <div class="card-bg ">
        <div class = "col l6 s6 m6 content-tag-div">
            <div class = "about-tag">
              <?php echo $row['tag_1'] ?>
            </div>
            <div class = "type-tag">
              <?php echo $row['input_type'] ?>
            </div>
        </div>
        <div class= "card-img"
            style= "background-image: url(' <?php echo $row['file_path'] ?> ');">
        </div>

        <div class="card-body">
            <div class = "card-title">
                <?php echo $row['title'] ?>
            </div>
            <div class = "card-description">
                <?php echo $row['tag_line'] ?>
            </div>
        </div>
      </div>
  </div>

<?php }} ?>
