$(document).ready(function(){
    $('#searchStudents').keyup(function(){
        var query = $(this).val();
  
        $.ajax({
            url: 'searchStudents.php',
            method: 'POST',
            data: { query: query },
            success: function(data){
                $('#studentsTable').html(data);
            }
        });
    });
  });
  