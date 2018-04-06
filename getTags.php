<?php
// AJAX search by specific input type (article or video) and category

include "card-model.php";
require "connection.php";

// receive inputs from get request
$input_type = $_REQUEST["input_type"];
$tag = $_REQUEST["tag"];

// display all on default of articles or video page
if ($tag =="ALL"){
  $query = "SELECT * FROM posts2 WHERE input_type = :input_type";
  $params = array(
    ":input_type" => $input_type,
  );
}

// display specific category
else{
  // search based on the specific input and the 1 tag, check both tag_1 and tag_2
  $query = "SELECT * FROM posts2 WHERE input_type = :input_type AND ( tag_1 = :input_tag_1 OR tag_2 = :input_tag_2 ) ";
  $params = array(
    ":input_type" => $input_type,
    ":input_tag_1" => $tag,
    ":input_tag_2"=> $tag,
  );

}

$table = exec_sql_query($conn, $query, $params)->fetchAll();

foreach ($table as $row){
  generateCard($row);
}

?>
