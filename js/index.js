$("#submission_form").bind("submit", function () {
  var ext = $('#input_photo').val().split('.').pop().toLowerCase();
  if ($.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {
    alert('Invalid File Extension!');
  };
});


// active page highlighter

$(function(){
    var pathname = (window.location.pathname.match(/[^\/]+$/)[0]);
    pathname = pathname.slice(0, -4);

    $('#nav-mobile li a').each(function() {
      console.log($(this).attr("id"));
      console.log(pathname);
    if ($(this).attr('id') == pathname)
    {
        $(this).addClass('current');
    }
    });
});



// assert character length on tagline
$(document).ready(function() {
    $('#tag_line').characterCounter();
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
