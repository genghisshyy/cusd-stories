// tabletop reference:   https://github.com/jsoma/tabletop
// handlebars reference: https://github.com/mardix/Handlebars

var publicSpreadsheetUrl = 'https://docs.google.com/spreadsheets/d/1jS3t5cf0vfyZ1Ay2SDmwunkIYzoIOrpRudVTqU01h4E/edit?usp=sharing';

function init() {
  Tabletop.init({
    key: publicSpreadsheetUrl,
    callback: showInfo,
    simpleSheet: true
  })
}

function showInfo(data, tabletop) {
  console.log ("setup successful!");
  console.log(data);
  data.forEach(function(element) {
    $(".container").append("<div class='item'>" + element.Timestamp + ", " + element.Title + "");
  }, this);
  
}

window.addEventListener('DOMContentLoaded', init)