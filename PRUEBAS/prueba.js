$(document).ready(function(){
  $('#search').keyup(function(){
      var query = $(this).val();

      $.ajax({
          url: 'buscar_profesores.php',
          method: 'POST',
          data: { query: query },
          success: function(data){
              $('#profesoresTable').html(data);
          }
      });
  });
});
