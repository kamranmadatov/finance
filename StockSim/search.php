<?php
if (isset($_GET['showSt'])) {
	$showSt = $_GET['showSt'];
} else {
	$showSt = 0;
};
if (isset($_GET['st'])) {
	$st = $_GET['st'];
};
?>
<html>
  <head>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400;300' rel='stylesheet' type='text/css'>
    <link href='css/style.css' rel='stylesheet'>
    <link href='css/model-u.css' rel='stylesheet'>
	<link href='css/bootstrap.css' rel='stylesheet'>
    <title>Search a Stock</title>
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/tv.js"></script>
    <script src="js/jquery.ajax-cross-origin.min.js"></script>
    <script src="js/app.js"></script>
	<!-- <script src="js/dropDown.js"></script> -->
	<script type="text/javascript" charset="utf-8" src="js/jquery.leanModal.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
  </head>
	<?php
		if ($showSt == 1) {
			echo '<script type="text/javascript">Ticker("'.$st.'");</script>';
		};
	?>
  <body>
    <div class="scroll-pane">
        
    <div class="menu">
      
      <!-- Menu icon -->
      <div class="icon-close">
        <img src="http://s3.amazonaws.com/codecademy-content/courses/ltp2/img/uber/close.png">
      </div>

      <!-- Menu -->
      <ul>
		<li><a href="profile.php"><img align="center" src="icon/home.png" class="icon"></a></li>
        <li><a href="#"></a><img align="center" src="icon/search.png" class="icon"></li>
        <li><a href="browse.php"><img align="center" src="icon/browse.png" class="icon"></a></li>
        <!-- <li><a href=""><img align="center" src="icon/people.png" class="icon"></a></li> -->
      </ul>
    </div>

    <!-- Main body -->
    <div class="jumbotron">
      <div class="icon-menu">
        <i class="fa fa-bars"></i>
        Navigation
      </div>
      <div id="w">
        <div id="content">
          <img src="icon/logo.png">
          <h1>Search Shares</h1>
          <div id="stockTickGet">
            Ticker: <input type="text" id="tickBox" list="options"/>
            <button onclick="Ticker()" id="tickerSubmit" class="btn btn-primary">Submit</button>
			<datalist id="options"></datalist>
          </div>
          <div id='showStockTick' class='stockTicker'></div>
          <!-- <div id='stockChart'></div> -->
          <div id='stockChart'>
          </div>      
          <div id='showStockSearch' class='stockTicker'></div>
          <div id='newsresult' class='stockTicker'></div>
          <div id="w"></div>
          <button class="btn btn-primary" data-toggle="modal" data-target="#modal1">Buy Stocks</button>
		  
		  <button class="btn btn-primary" onclick="watchList()">Add to Watch List</button>
          
        </div>

        <div id="modal1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Buy Stocks</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form role="form" id="buyform" method="post" action="php/buyStock.php">
					<div class="form-group">
                        <div class="input-group">
                            <label for="shares" class="input-group-addon glyphicon glyphicon-user">Amount of Shares:</label>
							<input type="text" class="form-control" id="shares" name="shares" placeholder="Shares Buying..." required>
                            <label for="start" class="input-group-addon glyphicon glyphicon-user">Start Price (0 for No Limit):</label>
							<input type="text" class="form-control" id="start" placeholder="(0 for No Limit)" value="0">
                            <label for="stop" class="input-group-addon glyphicon glyphicon-user">Stop Price(0 for No Limit):</label>
							<input type="text" class="form-control" id="stop" placeholder="(0 for No Limit)" value="0">
                            <label for="radiobutton" class="input-group-addon glyphicon glyphicon-user">Select Stock Method (Default - Buying Long):</label>
                            <div class="radio" id="radiobutton">
                                <label><input class="buysell" type="radio" name="optradio" value="buyLong">Buying Long</label>
                                <label><input class="buysell" type="radio" name="optradio" value="shortSell">Short Selling</label>
                            </div>
						</div> <!-- /.input-group -->
					</div> <!-- /.form-group -->

				</form>
              </div>
              <div class="modal-footer">
                <button onclick="buyTheStock()" type="button" class="btn btn-primary" name="buybtn">Confirm</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
              </div>
      </div>
    </div>
    </div>
   </div>
   </div>
  </div>
  </body>
</html>