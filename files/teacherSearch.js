$(document).ready(function(){
    $('#search').keyup(function(){
        var query = $(this).val();
  
        $.ajax({
            url: 'searchTeachers.php',
            method: 'POST',
            data: { query: query },
            success: function(data){
                $('#teachersTable').html(data);
            }
        });
    });
  });
  