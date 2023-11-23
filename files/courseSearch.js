$(document).ready(function(){
    $('#searchCourses').keyup(function(){
        var query = $(this).val();
  
        $.ajax({
            url: 'searchCourses.php',
            method: 'POST',
            data: { query: query },
            success: function(data){
                $('#coursesTable').html(data);
            }
        });
    });
  });
  