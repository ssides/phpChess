<?php 
  include_once('../config/db.php');
  include_once('../config/config.php');
  include('../controllers/isAuthenticated.php');
  
  if($_SERVER["REQUEST_METHOD"] === 'POST') {
    if (isset($_POST[$cookieName]) && isAuthenticated($_POST[$cookieName])) {

      $response = array();
      $response['ErrorMsg'] = "";
      
      if (isset($_POST['player'])) {
        $sql = "update `Game` set `Opponent` = '{$_POST['player']}', `OpponentInviteDate`=now() where `ID` = '{$_POST['gameID']}'";
        $update = mysqli_query($connection, $sql);
        if ($update === false) {
          $response['ErrorMsg'] .= mysqli_error($connection);
        }
      } else {
        $response['ErrorMsg'] .= "Player not set.";
      }
     
      http_response_code(200);
      echo json_encode($response);

    } else {
      echo "ID invalid or missing.";
    }
  } else {
    echo "Expecting request method: POST";
  }
?>