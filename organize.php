<?php
  include_once('authorize.php');
  include_once('controllers/organize.php');
  include_once('config/config.php');
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="./content/bootstrap-5.0.2-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo './content/css/site.css?v='.$version  ?>">
  <title>Organize a Game</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="./content/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
  <script src="./content/ko/knockout-3.5.1.js"></script>
</head>

<body>
  <!-- Header -->
  <?php include('header.php'); ?>

  <div class="App">
    <div class="vertical-center">
      <div class="inner-block gamePlay">

        <p class="text" data-bind="visible: !opponent() && !opponentJoined()">Select opponent.</p>
        <p class="text" data-bind="visible: opponent() && !opponentJoined()">Invite opponent.</p>
        <p class="text" data-bind="visible: opponent() && opponentJoined()">Start the game.</p>

        <div class="org-border">
          <span>Opponent</span><br />
          <select data-bind="visible: !opponentInvited(), options: users, optionsText: 'name', value: selectedOpponent, optionsCaption:'Select'"></select>
          <div data-bind="visible: opponentInvited">
            <table>
              <tr>
                <td style="vertical-align: middle;">
                  <div data-bind="visible: opponentInvited() ? selectedOpponent().thumbnailpath.length > 0 : false">
                    <img data-bind="attr: {src: opponentInvited() ? selectedOpponent().thumbnailpath : ''}" />
                  </div>
                </td>
                <td style="vertical-align: middle;">&nbsp;<span class="notice" data-bind="text: opponentInvited() ? selectedOpponent().name : ''"></span></td>
              </tr>
            </table>
          </div>
          <p class="notice" data-bind="visible: opponentJoined()">Joined</p>
        </div>
        </br>
        <div class="inviteMargin" data-bind="visible: opponent() & !opponentJoined()">
          <button data-bind="click: invite">Invite Opponent</button>
        </div>
        <div class="inviteMargin" data-bind="visible: opponentJoined()">
          <form action="" method="post">
            <table>
              <tr width="60">
                <td><label for="timedGame">Timed game:</label></td>
                <td><input id="timedGame" name="timedGame" type="checkbox" value="1" data-bind="checked: isTimedGame"></td>
              </tr>
              <tr data-bind="visible: isTimedGame()">
                <td><label for="gameTime">Game time:</label></td>
                <td><input id="gameTime" name="gameTime" type="number" style="width:60px" value="40" max="120" min="1"></td>
              </tr>
              <tr>
                <td><label for="opponentColor">Opponent color:</label></td>
                <td>
                  <select id="opponentColor" name="opponentColor">
                    <option value="pickOne" selected>Pick automatically</option>
                    <option value="white">White</option>
                    <option value="black">Black</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td></td>
                <td><button type="submit" name="startGame" id="startGame">Start Game</button></td>
              </tr>
            </table>
          </form>
        </div>

        <p class="error"><?php echo $errorMsg; ?></p>

      </div>
    </div>
  </div>
  <?php include('content/js/organize.php') ?>
</body>

</html>