<?php 
    include_once('config/db.php');
    include_once('config/config.php');
    include_once('svc/services.php');
    
    if (empty($_COOKIE[$cookieName])) {
      header('Location: index.php');
    } else {
      if(isset($_POST['organize'])) {
        $gameID = startGame($_COOKIE[$cookieName]);
        if (!empty($gameID)) {
          $_SESSION['gameID'] = $gameID;
          header("Location: organize.php");
        }
      } else if (isset($_POST['join']) || isset($_POST['rejoin'])) {
        $gameID = $_POST['gameid'];
        $playerID = $_COOKIE[$cookieName];
      
        $_SESSION['gameID'] = $gameID;
        
        if (strlen($sqlErr) == 0) {
          joinGame($gameID, $playerID);
          if (strlen($sqlErr) == 0) {
            header("Location: play.php");
          }
        }
      }
    }
    
    function joinGame($gameID, $playerID) {
      global $sqlErr,$connection;
      
      $sql = "update `Game` set `OpponentJoinDate` = now() where `Opponent` = '{$playerID}' and `ID` = '{$gameID}'";
      if (mysqli_query($connection, $sql) === false) {
        $sqlErr = mysqli_error($connection);
      }
      return ;
    }
    
    function startGame($playerID) {
      global $sqlErr,$connection;
      $gameID = GUID();
      $zero = 0;
      $smt = mysqli_prepare($connection, "insert into `Game` (`ID`,`Organizer`,`InsertDate`,`UpdateDate`) values (?,?,now(),now())");
      mysqli_stmt_bind_param($smt, 'ss', $gameID, $playerID);
      if (!mysqli_stmt_execute($smt)){
        $sqlErr = mysqli_error($connection);
        $gameID = '';
      }
      mysqli_stmt_close($smt);

      return $gameID;
    }
?>