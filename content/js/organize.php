<?php include_once('../../config/config.php'); ?>

<script type="text/javascript">
  
  function player(name, id, thumbnailpath) {
    this.name = name;
    this.id = id;
    this.thumbnailpath = thumbnailpath;
  }

  function organizeViewModel() {
    var self = this;
    
    self.getRSVPSTimer = null;
    self.getRSVPSInProgress = false;   // lets the $.ajax() call take more than a second to complete.
    self.users = ko.observableArray();
    self.selectedOpponent = ko.observable();
    self.opponentInvited = ko.observable(false);
    self.opponentJoined = ko.observable(false);
    self.opponent = ko.computed(function () {
      return self.selectedOpponent() !== undefined;
    });

    self.invitePlayer = function(postData) {
      $.ajax({
        method: 'POST',
        url: 'api/invitePlayer.php',
        data: postData,
        success: function (response) {
          if (response == 'OK') {
            self.opponentInvited(true);
          }
        },
        error: function (xhr, status, error) {
          console.log(xhr.responseText);
          console.log(error);
        }
      });
    };

    self.inviteOpponent = function() {
      var postData = { <?php echo $cookieName.':'."'{$_COOKIE[$cookieName]}'"
                            .",gameID:'{$_SESSION['gameID']}'"   ?>
                ,player: this.selectedPartner().id};
      self.invitePlayer(postData);
    };
    
    self.getRSVPs = function() {
      if (!self.getRSVPSInProgress){
        self.getRSVPSInProgress = true;
        var postData = { <?php echo $cookieName.':'."'{$_COOKIE[$cookieName]}'"
                      .",gameID:'{$_SESSION['gameID']}'"   ?> };
        self.getRSVPSInProgress = $.ajax({
          method: 'POST',
          url: 'api/getRSVPs.php',
          data: postData,
          success: function (response) {
            let data = JSON.parse(response);
            if (data.OpponentJoinDate) {
              self.opponentJoined(true);
            }
          },
          error: function (xhr, status, error) {
            clearInterval(self.getRSVPSTimer);
            console.log(xhr.responseText);
            console.log(error);
          },
          complete: function(){
            self.getRSVPSInProgress = false;
          }
        });
      }
    };
    
    self.invite = function() {
      if (!self.opponentInvited()) {
        self.inviteOpponent();
      }    
      if (!self.rightInvited()) {
        self.inviteRight();
      }    
      if (!self.partnerInvited()) {
        self.invitePartner();
      }    
    };
    
    self.initialize = function() {
      $.ajax({
        method: 'POST',
        url: 'api/getUsers.php',
        data: { <?php echo $cookieName.':'."'{$_COOKIE[$cookieName]}'"?> },
        success: function (response) {
          let data = JSON.parse(response);
          if (data.ErrorMsg) {
            console.log(data.ErrorMsg);
          }
          data.Users.forEach(function (i) {
            self.users.push(new player(i[1], i[0], i[2]));
          });
        },
        error: function (xhr, status, error) {
          console.log(error);
        }
      });
      
      self.getRSVPSTimer = setInterval(self.getRSVPs, 1000);
    };
    
    self.initialize();
  }

  $(function () {
    
    ko.applyBindings(new organizeViewModel());
    
  });
</script>
