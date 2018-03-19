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

