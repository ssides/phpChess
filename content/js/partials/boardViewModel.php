<script type="text/javascript">

  function squareViewModel(squareID, color) {
    var self = this;

    self.squareID = squareID;
    self.pieceID = ko.observable('');
    self.pieceURL = ko.observable('');
    self.color = color;
    // self.draggable = ko.computed(function(){ return self.pieceURL().length > 0; });
    
    self.drop = function(data, event, root) {
       console.log('move  ' + root.movingPiece + ' from ' + root.fromLocation + ' to ' + event.target.id );
       root.move(root.movingPiece, root.fromLocation, event.target.id);
    };
    
    self.take = function(data, event, root) {
       console.log(root.movingPiece + ' takes ' + event.target.id + ' at ' + data.squareID + ' from ' + root.fromLocation );
       root.move(root.movingPiece, root.fromLocation, data.squareID);
    };
    
    self.preventDefault = function(data, event) {
        event.preventDefault();
    };
    
    self.dragstart = function(data, event, root){
      console.log('dragstart(' + event.target.id + ')');
      root.movingPiece = event.target.id;
      root.fromLocation = data.squareID;
      return true;
    };
  }
  
  function rankViewModel() {
    var self = this;
    
    self.boardColumn  = ko.observableArray();
  }

  function boardViewModel() {
    var self = this;
    
    self.movingPiece = '';
    self.fromLocation = '';
    self.toLocation = '';
    
    self.boardRank = ko.observableArray();
    
    self.fillBoard = function(pieces){
      self.boardRank().forEach(function(b){
        b.boardColumn().forEach(function(c){
          var p = pieces.find(e => e.squareID == c.squareID);
          var url = p ? app.getPieceURL(p.pieceID) : '';
          var pid = p ? p.pieceID : '';
          c.pieceURL(url);
          c.pieceID(pid);
        });
      });
    };
    
    self.move = function(pieceID, fromID, toID){
        self.boardRank().forEach(function(b){
        b.boardColumn().forEach(function(c){
          if (c.squareID == fromID) {
            c.pieceURL('');
            c.pieceID('');
          } else if (c.squareID == toID) {
            c.pieceURL(app.getPieceURL(pieceID));
            c.pieceID(pieceID);
          }
        });
      });

    };
    
    // self.update() is called on every game controller timer tick.
    self.update = function(game) {
      self.fillBoard(game.pieces);
    };
     
    self.initializeAsWhite = function() {
      var br = [];
      var columns = ['a','b','c','d','e','f','g','h'];
      var rank = 8;
      var firstColor = 'light';
      
      while (rank > 0) {
        var currentColor = firstColor;
        var r = new rankViewModel();
        var ca = [];
        columns.forEach(function(c){
          ca.push(new squareViewModel(c + rank, currentColor));
          currentColor = currentColor == 'light' ? 'dark' : 'light';
        });
        r.boardColumn(ca);
        
        br.push(r);
        rank -= 1;
        firstColor = firstColor == 'light' ? 'dark' : 'light';
      }

      self.boardRank(br);
    };
    
    self.initializeAsBlack = function() {
      var br = [];
      var columns = ['h','g','f','e','d','c','b','a'];
      var rank = 1;
      var firstColor = 'light';
      
      while (rank < 9) {
        var currentColor = firstColor;
        var r = new rankViewModel();
        var ca = [];
        columns.forEach(function(c){
          ca.push(new squareViewModel(c + rank, currentColor, ''));
          currentColor = currentColor == 'light' ? 'dark' : 'light';
        });
        r.boardColumn(ca);
        
        br.push(r);
        rank += 1;
        firstColor = firstColor == 'light' ? 'dark' : 'light';
      }

      self.boardRank(br);
    };
    
    self.initialize = function(){
      self.initializeAsWhite();
    };
    
    self.initialize();
  }

</script>