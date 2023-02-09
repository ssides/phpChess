<?php 
  include_once('../config/db.php');
  include_once('../config/config.php');
  include('../controllers/isAuthenticated.php');
  
  if($_SERVER["REQUEST_METHOD"] === 'POST') {
    if (isset($_POST[$cookieName]) && isAuthenticated($_POST[$cookieName])) {

      $game = array();
      $game['ErrorMsg'] = "";
      $sql = "select `OpponentJoinDate` from `Game` where `ID` = '{$_POST['gameID']}'";
      $results = mysqli_query($connection, $sql);
      
      if ($results === false) {
        $game['ErrorMsg'] .= mysqli_error($connection);
      } else {
        while ($row = mysqli_fetch_array($results)) {
          $game['OpponentJoinDate'] = is_null($row['OpponentJoinDate']) ? '' : $row['OpponentJoinDate'];
        }
      }
     
      http_response_code(200);
      echo json_encode($game);

    } else {
      echo "ID invalid or missing.";
    }
  } else {
    echo "Expecting request method: POST";
  }
?>