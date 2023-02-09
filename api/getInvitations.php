<?php 
  include_once('../config/db.php');
  include_once('../config/config.php');
  include('../controllers/isAuthenticated.php');
  
  if($_SERVER["REQUEST_METHOD"] === 'POST') {
    if (isset($_POST[$cookieName]) && isAuthenticated($_POST[$cookieName])) {
      
      $playerID = $_POST[$cookieName];
      $invitations = array();
      $invitations['ErrorMsg'] = "";
      $invitations['Invites'] = array();

      $sql = "select
            g.`ID` `GameID`
            ,org.Name `OrganizerName`
          from `Game` g
          join `Player` org on g.Organizer = org.ID
          where `Opponent` = '{$playerID}' and OpponentJoinDate is null
          order by g.`InsertDate` desc";
          
      $results = mysqli_query($connection, $sql);
      if ($results === false) {
        $invitations['ErrorMsg'] .= mysqli_error($connection);
      } else {
        $i = array();
        while ($row = mysqli_fetch_array($results)) {
          array_push($i, array($row['GameID'],$row['OrganizerName'],$row['Position']));
        }
        $invitations['Invites'] = $i;
      }
      
      http_response_code(200);
      echo json_encode($invitations);
      
    } else {
      echo "ID invalid or missing.";
    }
  } else {
    echo "Expecting request method: POST";
  }
  
?>