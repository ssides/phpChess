<?php
  include('authorize.php');
  include_once('config/config.php');
 ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="./content/bootstrap-5.0.2-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo './content/css/site.css?v='.$version ?>">
  <title>Sides Family Euchre - Play</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="./content/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
  <script src="./content/ko/knockout-3.5.1.js"></script>
</head>

<body>

  <?php include('header.php'); ?>

  <div class="App">
    <div class="vertical-center">
      <div class="inner-block justify-content-center">
        <div class="row">
          <div class="col">
            <div class="gamePlay">
              <table>
                <tr style="height: 50px">
                  <td class="light"></td>
                  <td class="dark"></td>
                  <td class="light"></td>
                  <td class="dark"></td>
                  <td class="light"></td>
                  <td class="dark"></td>
                  <td class="light"></td>
                  <td class="dark"></td>
                </tr>
                <tr style="height: 50px">
                  <td class="dark"><div class="piecePad"><img src="<?php echo $appUrl; ?>content/images/pieces/wp.png" style="width:<?php echo $pieceSize; ?>px;height:<?php echo $pieceSize; ?>px;"></div></td>
                  <td class="light"><div class="piecePad"><img src="<?php echo $appUrl; ?>content/images/pieces/wp.png" style="width:<?php echo $pieceSize; ?>px;height:<?php echo $pieceSize; ?>px;"></div></td>
                  <td class="dark"></td>
                  <td class="light"></td>
                  <td class="dark"></td>
                  <td class="light"></td>
                  <td class="dark"></td>
                  <td class="light"></td>
                </tr>
                <tr style="height: 50px">
                  <td class="light"></td>
                  <td class="dark"></td>
                  <td class="light"></td>
                  <td class="dark"></td>
                  <td class="light"></td>
                  <td class="dark"></td>
                  <td class="light"></td>
                  <td class="dark"></td>
                </tr>
                <tr style="height: 50px">
                  <td class="dark"></td>
                  <td class="light"></td>
                  <td class="dark"></td>
                  <td class="light"></td>
                  <td class="dark"></td>
                  <td class="light"></td>
                  <td class="dark"></td>
                  <td class="light"></td>
                </tr>
                <tr style="height: 50px">
                  <td class="light"></td>
                  <td class="dark"></td>
                  <td class="light"></td>
                  <td class="dark"></td>
                  <td class="light"></td>
                  <td class="dark"></td>
                  <td class="light"></td>
                  <td class="dark"></td>
                </tr>
                <tr style="height: 50px">
                  <td class="dark"></td>
                  <td class="light"></td>
                  <td class="dark"></td>
                  <td class="light"></td>
                  <td class="dark"></td>
                  <td class="light"></td>
                  <td class="dark"></td>
                  <td class="light"></td>
                </tr>
                <tr style="height: 50px">
                  <td class="light"></td>
                  <td class="dark"></td>
                  <td class="light"></td>
                  <td class="dark"></td>
                  <td class="light"></td>
                  <td class="dark"><div class="piecePad"><img src="<?php echo $appUrl; ?>content/images/pieces/bp.png" style="width:<?php echo $pieceSize; ?>px;height:<?php echo $pieceSize; ?>px;"></div></td>
                  <td class="light"><div class="piecePad"><img src="<?php echo $appUrl; ?>content/images/pieces/bp.png" style="width:<?php echo $pieceSize; ?>px;height:<?php echo $pieceSize; ?>px;"></div></td>
                  <td class="dark"></td>
                </tr>
                <tr style="height: 50px">
                  <td class="dark"></td>
                  <td class="light"></td>
                  <td class="dark"></td>
                  <td class="light"></td>
                  <td class="dark"></td>
                  <td class="light"></td>
                  <td class="dark"></td>
                  <td class="light"></td>
                </tr>
              </table>
            </div>
          </div>
          <div class="col">
            <div class="">
              If timed, show timer.
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <?php
  include('content/js/partials/app.php');
  include('content/js/partials/gameModel.php');
  include('content/js/play.php')
  ?>

</body>

</html>
