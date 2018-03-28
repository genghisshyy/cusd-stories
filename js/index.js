// tabletop reference:   https://github.com/jsoma/tabletop
// handlebars reference: https://github.com/mardix/Handlebars

// var publicSpreadsheetUrl = 'https://docs.google.com/spreadsheets/d/1Ng5mELTWQJatDN1n5LUdf8UzVsSkqkBR5KbeKtKFcAk/edit?usp=sharing';

// function init() {
//   Tabletop.init({
//     key: publicSpreadsheetUrl,
//     callback: showInfo,
//     simpleSheet: true
//   })
// }

// function showInfo(data, tabletop) {
//   console.log ("setup successful!");
//   console.log(data);
//   data.forEach(function(element) {
//     $(".container").append("<div class='item'><p>" + element.Timestamp + ", " + element.Title + "</p> </div>");
//   }, this);

// }

// window.addEventListener('DOMContentLoaded', init)

$("#submission_form").bind("submit", function () {
  var ext = $('#input_photo').val().split('.').pop().toLowerCase();
  if ($.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {
    alert('Invalid File Extension!');
  };
});




function getData(c) {
  var x, i;
  x = document.getElementsByClassName("filterDiv");
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
//
// $('.butn').click(function() {
//     $(this).toggleClass('active');
// });
//
//
// var btnContainer = document.getElementById("container");
// var btns = btnContainer.getElementsByClassName("butn");
//
// for (var i = 0; i < btns.length; i++) {
//   btns[i].addEventListener("click", function() {
//     var current = document.getElementsByClassName("active");
//     current[0].className = current[0].className.replace(" active", "");
//     this.className += " active";
//   });
// }
