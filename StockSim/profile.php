<?php
session_start();
include_once 'php/database_connect.php';
$userID = $_SESSION['username'];
$IDnum = $_SESSION['IDnum'];
include 'php/getInfo.php';
$infoarray = $_SESSION['infoarray']; 
?>

<html>
  <head>  
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400;300' rel='stylesheet' type='text/css'>
    <link href='css/style.css' rel='stylesheet'>
	<link href='css/bootstrap.css' rel='stylesheet'>
    <title>Homepage</title>
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/jquery.ajax-cross-origin.min.js"></script>
    <script src="js/app.js"></script>
	<script type="text/javascript" charset="utf-8" src="js/jquery.leanModal.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
  </head>
  <body>
    <div class="scroll-pane">
    <div class="menu">
      
      <!-- Menu icon -->
      <div class="icon-close">
        <img src="http://s3.amazonaws.com/codecademy-content/courses/ltp2/img/uber/close.png">
      </div>

      <!-- Menu -->
      <ul>
		<li><a href="#"><img align="center" src="icon/home.png" class="icon"></a></li>
        <li><a href="search.php"><img align="center" src="icon/search.png" class="icon"></a></li>
        <li><a href="browse.html"><img align="center" src="icon/browse.png" class="icon"></a></li>
        <!-- <li><a href=""><img align="center" src="icon/people.png" class="icon"></a></li> -->
      </ul>
    </div>

    <!-- Main body -->
    <div class="jumbotron">

      <div class="icon-menu">
        <i class="fa fa-bars">Navigation</i>
      </div>
      <div id="w">
          <div id="content">
          <img src="icon/logo.png" align="center">
          
          <h1>Welcome, <?php echo $infoarray["first_name"] ?> </h1>
          <div class="container">
          <img src="icon/profile.png">
          <h3>Balance($): <?php echo $infoarray["balance"]?></h3>
          <h2>Current Holdings</h2>
          <table class="table table-borderless table-hover table-responsive">
              <thead class="thead-inverse">
                  <tr>
                      <th>Order Number</th>
                      <th>Company Name</th>
                      <th>Symbol</th>
                      <th>Bought Price</th>
                      <th>Current Price</th>
                      <th>Shares</th>
                      <th>Profit</th>
                      <th>Type of Stock</th>
                      <th></th>
                  </tr>
              </thead>
              <tbody>
              <?php
                while($transarray = mysqli_fetch_array($_SESSION['trans'])){
                 echo
                 "<tr>
                      <td>".$transarray['trans_num']."</td>
                      <td>".$transarray['stock_name']."</td>
                      <td>".$transarray['stock_ticker']."</td>
                      <td>". $transarray['stock_bp']."</td>
                      <td class='stockprofit quotes'>"."</td>
                      <td>".$transarray['stock_shares']."</td>
                      <td>".$transarray['stock_change']."</td>
                      <td>".$transarray['stock_type']."</td>
                      <td><button class='sellButton btn btn-primary' data-target='#modalsell' id='sellStock'>Sell Stock</button></td>
					  <td><button class='btn btn-primary' onclick='view(\"".$transarray['stock_ticker']."\")'>View Details</button></td>
                  </tr>";
                }
              ?>

            </tbody>
            </table>
              
            <h2>Current Buy Orders</h2>
            <table class="table table-borderless table-hover table-responsive">
              <thead class="thead-inverse">
                  <tr>
                      <th>Order Number</th>
                      <th>Company Name</th>
                      <th>Symbol</th>
                      <th>Current Price</th>
                      <th>Shares</th>
                      <th>Start Price</th>
                      <th>Stop Price</th>
                      <th>Type of Stock</th>
                      <th></th>
                  </tr>
              </thead>
              <tbody>
              <?php
                while($orderRows = mysqli_fetch_array($_SESSION['buyOrders'])){
                 echo" 
                 <tr>
                      <td>".$orderRows['trans_num']."</td>
                      <td>".$orderRows['stock_name']."</td>
                      <td>".$orderRows['stock_ticker']."</td>
                      <td>".$orderRows['stock_bp']."</td>
                      <td>".$orderRows['stock_shares']."</td>
                      <td>".$orderRows['stock_low']."</td>
                      <td>".$orderRows['stock_high']."</td>
                      <td>".$orderRows['orderType']."</td>
                      <td><button class='btn btn-primary' data-toggle='modal' onclick='cancelOrder($(this))' id='cancelOrder'>Cancel</button></td>
					  <td><button class='btn btn-primary' onclick='view(\"".$orderRows['stock_ticker']."\")'>View Details</button></td>
                  </tr>";
                }
              ?>
            </tbody>
            </table>
            
            <h2>Current Sell Orders</h2>
            <table class="table table-borderless table-hover table-responsive">
              <thead class="thead-inverse">
                  <tr>
                      <th>Order Number</th>
                      <th>Company Name</th>
                      <th>Symbol</th>
                      <th>Current Price</th>
                      <th>Shares</th>
                      <th>Start Price</th>
                      <th>Stop Price</th>
                      <th>Type of Stock</th>
                      <th></th>
                  </tr>
              </thead>
              <tbody>
              <?php
                while($orderRows = mysqli_fetch_array($_SESSION['sellOrders'])){
                 echo" 
                 <tr>
                      <td>".$orderRows['trans_num']."</td>
                      <td>".$orderRows['stock_name']."</td>
                      <td>".$orderRows['stock_ticker']."</td>
                      <td>".$orderRows['stock_bp']."</td>
                      <td>".$orderRows['stock_shares']."</td>
                      <td>".$orderRows['stock_low']."</td>
                      <td>".$orderRows['stock_high']."</td>
                      <td>".$orderRows['orderType']."</td>
                      <td><button class='btn btn-primary' data-toggle='modal' onclick='cancelSell($(this))' id='cancelOrder'>Cancel</button></td>
					  <td><button class='btn btn-primary' onclick='view(\"".$orderRows['stock_ticker']."\")'>View Details</button></td>
                  </tr>";
                }
              ?>
            </tbody>
            </table>
              
            <h2>Watch List</h2>
            <table class="table table-borderless table-hover table-responsive">
              <thead class="thead-inverse">
                  <tr>
					  <th>Watch Number</th>
                      <th>Company Name</th>
                      <th>Symbol</th>
					  <th>Price</th>
                      <th>Ask</th>
					  <th>Bid</th>
					  <th>Change</th>
					  <th>Percent Change</th>
					  <th>Average Volume</th>
                  </tr>
              </thead>
              <tbody>
              <?php
                while($watchRows = mysqli_fetch_array($_SESSION['watchLists'])){
                 echo" 
                 <tr>
				 	  <td>".$watchRows['num']."</td>
                      <td>".$watchRows['stock_name']."</td>
                      <td>".$watchRows['stock_ticker']."</td>
                      <td class='stockWatch'></td>
					  <td></td>
					  <td></td>
					  <td></td>
					  <td></td>
					  <td></td>
					  <td><button class='btn btn-primary' onclick='removeWatch(\"".$watchRows['num']."\")'>Remove</button></td>
					  <td><button class=\"buywatch btn btn-primary\" data-target=\"#modalbuywatch\">Buy Stocks</button></td>
					  <td><button class='btn btn-primary' onclick='view(\"".$watchRows['stock_ticker']."\")'>View Details</button></td>
                  </tr>";
                }
              ?>
            </tbody>
            </table>
			  
        </div>
        <div id="modalsell" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Sell Stocks</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form role="form">
					<div class="form-group">
                        <div class="input-group">
                            <label for="shares" class="input-group-addon glyphicon glyphicon-user">Amount of Shares:</label>
							<input type="text" class="form-control" id="sharess" placeholder="Shares Selling...">
                            <label for="start" class="input-group-addon glyphicon glyphicon-user">Min Sell Price (Starting Price - Long Only):</label>
							<input type="text" class="form-control" id="starts" placeholder="(0 for No Limit)" value="0">
                            
                            <label for="stop" class="input-group-addon glyphicon glyphicon-user">Max Sell Price (Stop Price - Short Only:</label>
							<input type="text" class="form-control" id="stops" placeholder="(0 for No Limit)" value="0">
						</div> <!-- /.input-group -->
					</div> <!-- /.form-group -->

				</form>
              </div>
              <div class="modal-footer">
                <button type="button" class="placesell btn btn-primary" data-toggle='modal' onclick="sellStock()">Place Sell</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
              </div>
            </div>
          </div>
      </div>
			  
        <div id="modalbuywatch" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Buy Stocks</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form role="form">
					<div class="form-group">
                        <div class="input-group">
                            <label for="shares" class="input-group-addon glyphicon glyphicon-user">Amount of Shares:</label>
							<input type="text" class="form-control" id="shares" name="shares" placeholder="Shares Buying..." required>
                            <label for="start" class="input-group-addon glyphicon glyphicon-user">Start Price (0 for No Limit):</label>
							<input type="text" class="form-control" id="start" placeholder="(0 for No Limit)" value="0">
                            <label for="stop" class="input-group-addon glyphicon glyphicon-user">Stop Price(0 for No Limit):</label>
							<input type="text" class="form-control" id="stop" placeholder="(0 for No Limit)" value="0">
                            <label for="radiobutton" class="input-group-addon glyphicon glyphicon-user">Select Stock Method(Default - Buying Long):</label>
                            <div class="radio" id="radiobutton">
                                <label><input class="buysell" type="radio" name="optradio" value="buyLong">Buying Long</label>
                                <label><input class="buysell" type="radio" name="optradio" value="shortSell">Short Selling</label>
                            </div>
						</div> <!-- /.input-group -->
					</div> <!-- /.form-group -->

				</form>
              </div>
              <div class="modal-footer">
                <button type="button" class="buywatch btn btn-primary" data-toggle='modal' onclick="buyStockWatch()" >Confirm</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
              </div>
      </div>
    </div>
    </div>
	<div align="center">
        <form role="form" id="loginform" method="post" action="php/clearsess.php">
			<button type="submit" class="btn btn-primary" data-dismiss="modal">Log Out</button>
        </form>
    </div>		  
   </div>
        </div>
		</div>
	  </div>
  </body>
</html>