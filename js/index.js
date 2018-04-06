$("#submission_form").bind("submit", function () {
  var ext = $('#input_photo').val().split('.').pop().toLowerCase();
  if ($.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {
    alert('Invalid File Extension!');
  };
});

// AJAX request the specific search query
function type_controller(input_type, tag){
  $.get( "getTags.php", {'input_type': input_type, 'tag': tag})
     .done(function( data ) {
       $(".main").empty();
       if (!$.trim(data)){
          $(".main").append("No Items found");
        }else{
          $(".main").append(data);
        }
     });
}
