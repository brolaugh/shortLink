<!DOCTYPE html>
<html lang="en">
<head>
  <title>Test123</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href='http://fonts.googleapis.com/css?family=Raleway:700,400' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.3.0/css/roboto.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.3.0/css/material-fullpalette.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.3.0/css/ripples.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.3.0/js/material.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.3.0/js/ripples.min.js"></script>
  <script srt="js/getlink.js"></script>

</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 jumbotron page-header">
        <h1>Short link</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <form class="form-control-static">
          <div class="form-group">
            <input class="floating-label" placeholder="URL to be shortened" name="long_url" type="url" autofocus="true" required="required"/>
          </div>
          <div class="form-group">
            <input class="floating-label" name="pref_url" type="text" placeholder="Prefered URL"/>
          </div>
          <button type="button" class="btn btn-primary btn-raised" data-toggle="modal" data-target="#shortlink" onClick="javascript:getUrl();">Get short link</button>

        </form>
        <!-- On submit show modal with link and 'copy to CopyToClipboard' button-->
        <!-- Modal -->
        <div id="shortlink" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Copy link</h4>
              </div>
              <div class="modal-body">
                <p id="result"></p>
                <a href="javascript:CopyToClipboard()" class="btn btn-primary">Copy link</a>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>

<?php

?>
