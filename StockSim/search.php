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
        <!-- <li><a href="browse.php"><img align="center" src="icon/browse.png" class="icon"></a></li> -->
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
            <button onclick="Ticker(); getAlphaVantagedata();" id="tickerSubmit" class="btn btn-primary">Submit</button>
      <datalist id="options"></datalist>
            
          </div>
          <div id='showStockTick' class='stockTicker'></div>
          <!-- <div id='stockChart'></div> -->
          <div id='stockChart'>
          </div>      
          <div id='showStockSearch' class='stockTicker'></div>
          <div id='newsresult' class='stockTicker'></div>
          <div id="w"></div>
          <!-- 
          <button class="btn btn-primary" data-toggle="modal" data-target="#modal1">Buy Stocks</button>
      -->
            <div class="container">
                                                                     
              <div class="table-responsive">          
              <table class="table">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Symbol</th>
                    <th>Company Name</th>
                    <th>Price </th>
                    <th>Change</th>
                    <th>Change Percent </th>

                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td id = "searchDate" ></td>
                    <td id = "companySymbol" ></td>
                    <td id = "companyName"></td>
                    <td id = "price"></td>
                    <td id = "change"></td>
                    <td id = "changePercent"></td>

                  </tr>
                </tbody>
              </table>
              </div>
            </div>
          
      <button class="btn btn-primary" onclick="watchList()">Add to Watch List</button>
          
    
<!--  <p>Symbol: &nbsp;<input id=inpSymbol value='MSFT' ></p>-->
<!--  <p><button onclick="getAlphaVantagedata()" >get Alpha Vantage Data</button></p>-->

<!--  <div id = "divContents" >Data will appear here. This may take a number of seconds.</div>-->
          <script>
// Thanks to http://www.alphavantage.co/

/*

Remember to upate the API key field with your key

Get your key here: https://www.alphavantage.co/support/#api-key

'Demo' API Key works only for exact copies of the demos in the documentation

*/


  const url = 'https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=MSFT&apikey=demo';


  function getAlphaVantagedata() {

    const apiKey = "VPMRFGI35I35L24UMRF";

//    const symbol = inpSymbol.value;
        const symbol = tickBox.value;

    //const url = 'https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=' + symbol + '&interval=1min&apikey=' + apiKey;
        const url = 'https://api.iextrading.com/1.0/stock/'+ symbol + '/quote'

    requestFile( url );

  }


  function requestFile( url ) {

    const xhr = new XMLHttpRequest();
    xhr.open( 'GET', url, true );
    xhr.onerror = function( xhr ) { console.log( 'error:', xhr  ); };
    xhr.onprogress = function( xhr ) { console.log( 'bytes loaded:', xhr.loaded  ); }; /// or something
    xhr.onload = callback;
    xhr.send( null );

    function callback( xhr ) {

      let response, json, lines;

      response = xhr.target.response;
      //divContents.innerText = response;
            
      json = JSON.parse( response );
             
            console.log( 'json', json );
            
//            var MyDate = new Date();
//            var MyDateString;
//                        
//            MyDateString =MyDate.getFullYear() + '-'+ ('0' + (MyDate.getMonth()+1)).slice(-2) + '-'
//             + ('0' + MyDate.getDate()).slice(-2);
//            console.log(MyDateString);
//            
//            console.log( 'json', json );
//            console.log( 'json', json["Meta Data"]["2. Symbol"]);
//            console.log( 'json', json["Time Series (Daily)"]);
//            console.log( 'json', json["Time Series (Daily)"][MyDateString]["4. close"]);
            
//            symbol.innerText = tickBox.innerText;
//            symbol.innerText = options.innerText;
//            console.log(tickBox.innerHTML);
//            console.log(options.innerHTML);
            
            var dateUpdate = new Date(json["latestUpdate"]);
            
            searchDate.innerText = dateUpdate;
            companySymbol.innerText = json["symbol"];
            companyName.innerText = json["companyName"];
            price.innerText = "$" +json["latestPrice"];
            change.innerText = "$"+json["change"];
            changePercent.innerText = json["changePercent"] + "%";
            
//            let notes;
//            notes=IMPORTJSON("https://api.iextrading.com/1.0/stock/aapl/chart/1d","low");
//            console.log('json', notes);
//            console.log('json', notes);
            //console.log( 'json', json.Meta Data[0].1. Information );

    }

  }
              
        function IMPORTJSON(url,xpath){
                
          try{
            // /rates/EUR
            var res = UrlFetchApp.fetch(url);
            var content = res.getContentText();
            var json = JSON.parse(content);

            var patharray = xpath.split("/");
            //Logger.log(patharray);

            for(var i=0;i<patharray.length;i++){
              json = json[patharray[i]];
            }

            //Logger.log(typeof(json));

            if(typeof(json) === "undefined"){
              return "Node Not Available";
            } else if(typeof(json) === "object"){
              var tempArr = [];

              for(var obj in json){
                tempArr.push([obj,json[obj]]);
              }
              return tempArr;
            } else if(typeof(json) !== "object") {
              return json;
            }
          }
          catch(err){
              return "Error getting data";  
          }

        }
              
        function getAlphaVantage(symbol) {
          var response = UrlFetchApp.fetch(url + symbol + "&apikey=" + api_key).getContentText();
          var data = JSON.parse(response);
          var timeSeries = data["Time Series (Daily)"];
          var value = 0.0;
          for (var dates in timeSeries) {
            value = timeSeries[dates]["4. close"];
            Logger.log("Within getAlphaVantage(symbol) function:" + value)
            if (value > 0.0) {
              break;
            }
          }
          return parseFloat(value);
        }

              
              
              
//   private void parseData(String response) {
//     try {
//        JSONObject responseJson = new JSONObject(response);
//
//        JSONObject timeSeriesJson = responseJson.getJSONObject("Time Series (Daily)");
//
//        JSONObject dailyObject = timeSeriesJson.getJSONObject(getYesterdayDateString());
//
//        String closePrice = dailyObject.getString("4. close");
//
//        Log.d("closePrice", closePrice);
//
//    } catch (JSONException e) {
//        e.printStackTrace();
//    }
//}


</script>
        </div>
        <!--
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
            </div>
          </div> 

        </form>
              </div>
              <div class="modal-footer">
                <button onclick="buyTheStock()" type="button" class="btn btn-primary" name="buybtn">Confirm</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
              </div>
      </div> 
        -->
    </div>
    </div>
   </div>

  </body>
</html>