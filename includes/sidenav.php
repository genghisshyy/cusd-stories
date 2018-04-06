<?php
//sidenav bar for the article and video page
?>
<div id="container">
  <div id="menu">
    <ul id="slide-out" class="side-nav fixed">
      <li id ="type_header" >
        <a href="#!" class ="heading" onclick="type_controller('<?php echo $current_page?>', 'ALL')">
          <?php if($current_page == "article"){ echo "Articles";} else{ echo "Videos"; } ?>
        </a>
      </li>
      <li><a href="#!" id = "people" class = "butn" onclick="type_controller('<?php echo $current_page?>','people')">People</a></li>
      <li><a href="#!" id = "impact" class = "butn" onclick="type_controller('<?php echo $current_page?>','impact')">Impact</a></li>
      <li><a href="#!" id = "education" class = "butn" onclick="type_controller('<?php echo $current_page?>','education')">Education</a></li>
      <li><a href="#!" id = "lifestyle" class = "butn" onclick="type_controller('<?php echo $current_page?>','lifestyle')">Lifestyle</a></li>
      <li><a href="#!" id = "events" class = "butn" onclick="type_controller('<?php echo $current_page?>','events')">Events</a></li>
      <li class="no-padding"></li>
    </ul>
  </div>
