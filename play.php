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
  <title>Chess JS - Play</title>
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
            <div id="Board" class="gamePlay">
              <table>
                <tbody data-bind="foreach: boardRank">
                  <tr class="rank" data-bind="foreach: boardColumn">
                    <td data-bind="css: color">
                      <div data-bind="visible: pieceURL().length == 0, attr: {id: squareID }, event: {
                           dragover: preventDefault,
                           drop: function(data, event) { drop(data, event, $root); }
                      }">&nbsp;
                      </div>
                      <div class="piecePad" data-bind="visible: pieceURL().length > 0, attr: {id: squareID }">
                        <img draggable="true" data-bind="attr: {src: pieceURL(), id: pieceID() }, event: {
                           dragstart: function(data, event){ return dragstart(data, event, $root); },
                           dragover: preventDefault,
                           drop: function(data, event) { take(data, event, $root); }
                           }" style="width:<?php echo $pieceSize; ?>px;height:<?php echo $pieceSize; ?>px;" />
                      </div>
                    </td>
                  </tr>
                <tbody>
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
  include('content/js/partials/boardViewModel.php');
  include('content/js/play.php')
  ?>

</body>

</html>
