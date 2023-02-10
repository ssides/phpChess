<?php 
  include_once('../../config/config.php'); 
?>

<script type="text/javascript">
  
  function gameController() {
    var self = this;
    
    self.getGameTimer = null;
    self.getGameInProgress = false;   // lets the $.ajax() call take more than a second to complete.

    self.position = null;
    self.playerID = '<?php echo "{$_COOKIE[$cookieName]}"; ?>';
    self.boardVM = new boardViewModel();
    
    self.getGame = function(){
      if (!self.getGameInProgress) {
        console.log('getGame()');
        var game = {
          pieces: [
            {squareID: 'c5',pieceID: 'br'},
            {squareID: 'f8',pieceID: 'wr'},
            {squareID: 'b3',pieceID: 'bk'},
            {squareID: 'd7',pieceID: 'wk'}]
        };
        
        self.boardVM.update(game);
        clearInterval(self.getGameTimer);
      }
    };
    
    self.getGameTimer = setInterval(self.getGame, app.times.gameTime);
  }
  
  $(function (){
    var gc = new gameController();
    ko.applyBindings(gc.boardVM, $('#Board')[0]);
  });
  
</script>