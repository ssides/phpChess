<?php  
    include_once('config/db.php');
    include_once('config/config.php');
    
    if ($_SERVER["REQUEST_METHOD"] === 'POST') {
      if (empty($_COOKIE[$cookieName]) || empty($_SESSION['gameID'])) {
        header('Location: index.php');
      } else {
        $gameID = $_SESSION['gameID'];
        $errorMsg = "";
        
        if(isset($_POST['startGame'])) {
          $isTimed = $_POST['timedGame'] == '1' ? '1' : '0';
          $opponentColor = getOpponentColor($_POST['opponentColor']);
          $turn = $opponentColor == 'W' ? 'P' : 'R';
          if (strlen(setGameStartDate($_COOKIE[$cookieName], $_SESSION['gameID'], $isTimed, $_POST['gameTime'], $opponentColor, $turn)) == 0) {
            header('Location: play.php');
          }
        } else {
          $errorMsg = "Unknown button";
        }
      }
    }
    
    function setGameStartDate($playerID, $gameID, $isTimed, $gameTime, $opponentColor, $turn) {
      global $errorMsg,$connection;
      
      $sql = "update `Game` set `GameStartDate` = now(),`UpdateDate` = now(),`IsTimed` = '{$isTimed}',`OrganizerClock` = $gameTime * 60, `OpponentClock` = $gameTime * 60, `OpponentColor` = '{$opponentColor}', `Turn` = '{$turn}'
          where `Organizer` = '{$playerID}' and `ID` = '{$gameID}'";
      if (mysqli_query($connection, $sql) === false) {
        $errorMsg = mysqli_error($connection);
      }
      
      return $errorMsg;
    }
    
    function getOpponentColor($colorOption) {
      $result = 'W';
      
      switch($colorOption) {
        case 'pickOne':
          $result = mt_rand(0, 65535) > 32767 ? 'W' : 'B';
          break;
        case 'black':
          $result = 'B';
          break;
      };
      
      return $result;
    }
?>