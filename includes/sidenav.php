



<div id="container">
  <div id="menu">
    <ul id="slide-out" class="side-nav fixed">
      <li class = "heading"> Articles</li>
      <li><a href="#!" class = "butn" onclick="getData('people')">People</a></li>
      <li><a href="#!" class = "butn" onclick="getData('impact')">Impact</a></li>
        <li><a href="#!" class = "butn" onclick="getData('education')">Education</a></li>
          <li><a href="#!" class = "butn" onclick="getData('lifestyle')">Lifestyle</a></li>
            <li><a href="#!" class = "butn" onclick="getData('events')">Events</a></li>
      <li class="no-padding">
      </li>
    </ul>
  </div>



      <script>
      getData("all")

      function getData(c) {
        var x, i;
        x = document.getElementsByClassName("card-bg");
        if (c == "all") c = "";
        for (i = 0; i < x.length; i++) {
          RemoveClass(x[i], "show");
          if (x[i].className.indexOf(c) > -1) AddClass(x[i], "show");
        }
      }

      function AddClass(element, name) {
        var i, arr1, arr2;
        arr1 = element.className.split(" ");
        arr2 = name.split(" ");
        for (i = 0; i < arr2.length; i++) {
          if (arr1.indexOf(arr2[i]) == -1) {element.className += " " + arr2[i];}
        }
      }

      function RemoveClass(element, name) {
        var i, arr1, arr2;
        arr1 = element.className.split(" ");
        arr2 = name.split(" ");
        for (i = 0; i < arr2.length; i++) {
          while (arr1.indexOf(arr2[i]) > -1) {
            arr1.splice(arr1.indexOf(arr2[i]), 1);
          }
        }
        element.className = arr1.join(" ");
      }

      // Add active class to the current button (highlight it)
      var btnContainer = document.getElementById("container");
      var btns = btnContainer.getElementsByClassName("butn");
      for (var i = 0; i < btns.length; i++) {
        btns[i].addEventListener("click", function(){
          var current = document.getElementsByClassName("active");
          current[0].className = current[0].className.replace(" active", "");
          this.className += " active";
        });
      }
      </script>


<!--
https://stackoverflow.com/questions/7803814/prevent-refresh-of-page-when-button-inside-form-clicked -->

  <!-- <script type="text/javascript">
  function filtersearch()
  {
      location.href = document.getElementById('link_id').value;
  }
  </script> -->
