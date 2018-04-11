<?php
// the model for an individual card
// this is designed to be used within a foreach loop to kick out the individual cards
function generateCard($row){
  // if there's two tags in the database on this element
  if ($row['tag_2']!= "NULL"){
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
  // if they don't have 2 tags in the database
  else{
    echo '
    <a href ="'.$row['url'].'">
    <div class="col s12 l4">
          <div class="card-bg">
            <div class = "content-tag-div">
                <div class = "col s3 about-tag">
                  '.ucfirst($row['tag_1']).'
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

  }
?>
