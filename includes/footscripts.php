  <script>
    $(function () {
      // $('#myModal').modal('show');
      
      setTimeout(function(){
        $('#myModal').modal('show');
      }, 2000);      
    })


// Music Player script
    $(document).ready(function () {
        $('.mediPlayer').mediaPlayer();
    }); 
  </script>

  <script type="text/javascript">
function copyToClipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val($(element).text()).select();
  document.execCommand("copy");
  $temp.remove();
} 
</script>
  
  <script src="music-player/jquery-music.js"></script>
  <script src="music-player/player.js"></script>
  <script type="text/javascript" src="bootstrap-4.3.1-dist/js/custom.js"></script>   
  <script type="text/javascript" src="bootstrap-4.3.1-dist/js/popper.js"></script>   
  <script src="bootstrap-4.3.1-dist/dist/bsnav.min.js"></script>
  <script type="text/javascript" src="bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
  <!-- <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js'></script> -->
</body>
</html>
    </body>
</html>