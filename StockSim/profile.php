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
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <script src="http://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="http://www.amcharts.com/lib/3/serial.js"></script>
    <script src="https://www.amcharts.com/lib/3/xy.js"></script>
    <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
    <script src="http://www.amcharts.com/lib/3/plugins/dataloader/dataloader.min.js"></script>
        <script>
        var chart = AmCharts.makeChart("chartdiv", {
            "type": "xy",
            "theme": "light",
            "marginRight": 80,
            "dataDateFormat": "YYYY-MM-DD",
            "startDuration": 1.5,
            "trendLines": [],
            "balloon": {
                "adjustBorderColor": false,
                "shadowAlpha": 0,
                "fixedPosition":true
            },        
            "dataLoader": {
                "url": "php/data.php",
                "format": "json",
            },
            "graphs": [{
                "balloonText": "<div style='margin:5px;'><b>[[x]]</b><br>Sentiment Score:<b>[[y]]</b><br>URL:<b>[[articleURL]]</b></div>",
                "bullet": "diamond",
                "id": "AmGraph-1",
                "lineAlpha": 0,
                "lineColor": "#b0de09",
                "fillAlphas": 0,
                "xField": "date",
                "yField": "avgScore",
                "urlField": "articleURL"
            }],
            "valueAxes": [{
                "id": "ValueAxis-1",
                "axisAlpha": 0
            }, {
                "id": "ValueAxis-2",
                "axisAlpha": 0,
                "position": "bottom",
                "type": "date",
                "minimumDate": new Date().setDate(new Date().getDate() - 20),
                "maximumDate": new Date()
            }],
            "allLabels": [],
            "titles": [],
            "chartScrollbar": {
                "offset": 15,
                "scrollbarHeight": 5
            },

            "chartCursor":{
               "pan":true,
               "cursorAlpha":0,
               "valueLineAlpha":0
            }
        });
      </script>
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
          
          <h1>Welcome, <?php echo $IDnum ?> </h1>
          <div class="container">
          <img src="icon/profile.png">          
            <h2>Watch List</h2>
            <table class="table table-borderless table-hover table-responsive">
              <thead class="thead-inverse">
                  <tr>
					  <th>Trans ID</th>
                      <th>Company Name</th>
                      <th>Symbol</th>
                      <th>Sentiment Analysis</th>
                  </tr>
              </thead>
              <tbody>
              <?php
                while($watchRows = mysqli_fetch_array($_SESSION['transaction'])){
                 $result = mysqli_query($conn, "SELECT AVG(sentScore) FROM articles WHERE company ='".$watchRows['Company']."';");
                 $array = mysqli_fetch_row($result);
                 echo" 
                 <tr>
				 	  <td>".$watchRows['id']."</td>
                      <td>".$watchRows['Company']."</td>
                      <td>".$watchRows['Ticker']."</td>
                      <td>".$array[0]."</td>
					  <td><button class='btn btn-primary' onclick='removeWatch(\"".$watchRows['id']."\")'>Remove</button></td>
					  <td><button class='btn btn-primary' onclick='view(\"".$watchRows['Ticker']."\")'>View Details</button></td>
                  </tr>";
                }
              ?>
            </tbody>
            </table>
			  
        </div>
        <div id="chartdiv" style="height: 300px; width: 100%;"></div>
        <?php
            $date = date_create();
            $old = date_format(date_sub($date, date_interval_create_from_date_string('20 days')), 'Y-m-d');
            $date = date_format(date_create(), 'Y-m-d');
            $query = "SELECT articleURL,date, sentScore as avgScore FROM articles WHERE date <= '".$date."' AND date >= '".$old."' ORDER BY date ";
            //echo $query;
            $result = mysqli_query($conn, $query);
            $data = array();
            while ($row = mysqli_fetch_assoc($result)){
                $data[] = $row;
            }
            //echo json_encode($data);   
        ?>
        <!-- <div id="myDiv" style="width: 480px; height: 300px; width: 100%;"></div> -->
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