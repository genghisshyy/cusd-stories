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
  // $conn = new PDO ("pgsql:".$connection_string);
  $conn = pg_pconnect($connection_string);
  var_dump($conn);

  $table = pg_query($conn, "SELECT * FROM posts2");

  var_dump($table);
  // $table = $conn->query("SELECT * FROM posts2");
  // var_dump($table);

  // while ($row = pg_fetch_row($table)) {
  // var_dump($row);
  // }
