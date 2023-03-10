<?php include_once('../../config/config.php'); ?>

<script type="text/javascript">

  function game(gameID, organizerName) {
    this.gameID = gameID;
    this.organizerName = organizerName;
  }

  function dashboardViewModel() {
    var self = this;
    
    self.invitationTimer = null;
    self.invitationInProgress = false;  // lets the $.ajax() call take more than a second to complete.
    self.invitations = ko.observableArray([]);
    self.rejoinTimer = null;
    self.rejoinInProgress = false;
    self.rejoinGames = ko.observableArray([]);

    self.getInvitations = function() {
      if (!self.invitationInProgress) {
        console.log('getInvitations()');
        self.invitationInProgress = true;
        var postData = { <?php echo $cookieName.':'."'{$_COOKIE[$cookieName]}'" ?> };
        $.ajax({
          method: 'POST',
          url: 'api/getInvitations.php',
          data: postData,
          success: function (response) {
            let data = JSON.parse(response);
            if (data.ErrorMsg) {
              console.log(data.ErrorMsg);
            }
            if (data.Invites.length > 0) {
              var invites = [];
              // stop the timer and wait for the player to respond.
              clearInterval(self.invitationTimer);
              data.Invites.forEach(function(i){
                invites.push(new game(i[0], i[1]));
              });
              self.invitations(invites);
            }
          },
          error: function (xhr, status, error) {
            console.log(xhr.responseText);
            console.log(error);
          },
          complete: function(){
            self.invitationInProgress = false;
          }
        });
      }
    };

    self.getRejoinableGames = function(){
      if (!self.rejoinInProgress) {
        self.rejoinInProgress = true;
        console.log('getRejoinableGames()');
        var postData = { <?php echo $cookieName.':'."'{$_COOKIE[$cookieName]}'" ?> };
        $.ajax({
          method: 'POST',
          url: 'api/getRejoinableGames.php',
          data: postData,
          success: function (response) {
            console.log('received getRejoinableGames response');
            let data = JSON.parse(response);
            if (data.length > 0) {
              var r = [];
              // stop the timer and wait for the player to respond.
              clearInterval(self.rejoinTimer);
              data.forEach(function(i){
                r.push(new game(i[0], i[1]));
              });
              self.rejoinGames(r);
            }
          },
          error: function (xhr, status, error) {
            console.log(xhr.responseText);
            console.log(error);
          },
          complete: function(){
            self.rejoinInProgress = false;
          }
        });
      }
    };
    
    self.initialize = function() {
      console.log('start timer invitationTimer.');
      self.invitationTimer = setInterval(self.getInvitations, 1000);
      // start another timer to get games from the last three days 
      // that can be rejoined.
      // everything needs to be stored in the database.  I need a Play table
      // that joins to Game. who is the dealer? what is trump?
      console.log('start timer rejoinTimer.');
      self.rejoinTimer = setInterval(self.getRejoinableGames, 1000);
      
      $('.uxRefreshInvites').click(function(){ self.getInvitations(); });
      $('.uxRefreshReJoins').click(function(){ self.getRejoinableGames(); });

    }
    
    self.initialize();
  }    
  
  $(function () {
    ko.applyBindings(new dashboardViewModel());
  });
</script>
