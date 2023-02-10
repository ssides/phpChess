<?php
  include_once('../../../config/config.php');
?>

<script type="text/javascript">

  app = {};
  
  app.times = {
    gameTime: 1000
  };

  app.appURL = '<?php echo $appUrl; ?>';
  app.getPieceURL = function(pieceID){
      return app.appURL + 'content/images/pieces/' + pieceID + '.png';
    };
</script>
