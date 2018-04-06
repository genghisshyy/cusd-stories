<?php
include "js-scripts.php";

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


// connection string for heroku
  $connection_string= "dbname=d9bvjse2g8ba1h host=ec2-54-243-210-70.compute-1.amazonaws.com port=5432 user=dxwirrhzaydomo password=62adc98f8f11caa8d9a71c385d70edb1483dbb761458189b20f5ba9f6ddfae6e sslmode=require";
  // PDO connection using heroku string
  $conn = new PDO ("pgsql:".$connection_string);
  $query = "SELECT * FROM posts2";
  $table = $conn->query($query);

foreach ($table as $row){
echo '
<a href ="'.$row['url'].'">
<div class="col s12 l4">
      <div class="card-bg">
        <div class = "content-tag-div">
            <div class = "col s3 about-tag">
              '.ucfirst($row['tag_1']).'
            </div>
            <div class = "col s3 about-tag">
              '.ucfirst($row['tag_2']).'
            </div>
            <div class = "col s3 type-tag">
              '.ucfirst($row['input_type']).'
            </div>
        </div>
        <div class= "card-img"
            style= "background-image: url('.$row['file_path'].');">
        </div>

        <div class="card-body">
            <div class = "card-title">
                '.$row['title'].'
            </div>
            <div class = "card-description">
                '.$row['tag_line'].'
            </div>
        </div>
      </div>

  </div>
  </a>';
  }
?>
