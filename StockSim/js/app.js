/*HELLO*/
$(function () {
  /* Push the body and the nav over by 285px over */
  $('.icon-menu').click(function () {
    $('.menu').animate({
      left: "0px"
    }, 200);

    $('body').animate({
      left: "90px"
    }, 200);
  });
  
    
  /* Then push them back */
  $('.icon-close').click(function () {
    $('.menu').animate({
      left: "-90px"
    }, 200);

    $('body').animate({
      left: "0px"
    }, 200);
  });
    
  $('a [href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
  });

});


/* Use to pass call-back button */
$(document).ready(function(){
    $(".sellButton").click(function () {
       $('#modalsell').modal('toggle', $(this));
    });
	$(".buywatch").click(function () {
       $('#modalbuywatch').modal('toggle', $(this));
    });
    $('#modalsell').on('show.bs.modal', function(button){
        var invoker = $(button.relatedTarget);
        var row = $(invoker).closest('tr');
        $(".placesell").click(function () {
            sellStock(row);
        });
    });
	$('#modalbuywatch').on('show.bs.modal', function(button){
        var invoker = $(button.relatedTarget);
        var row = $(invoker).closest('tr');
        $(".buywatch").click(function () {
            buyStockWatch(row);
        });
    });
    $('.stockprofit').each(function(){
        $(this).html(getPrices($(this)));
        /*
        $(this).hover(function(){
            $(this).css('background-color', '#ff0000');
        });
        */
    });
    
	$('.stockWatch').each(function(){
        $(this).html(getInfo($(this)));
    });
});   

function getInfo(e) {
	var ticker = e.closest('tr').find("td:nth-child(3)").text();
    var YQL_url = "https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.quotes%20where%20symbol%20in%20(%22" +ticker+ "%22)&format=json&env=store://datatables.org/alltableswithkeys";
    var stock, Ask, Bid, Change, PerChange, Volume;
    $.when($.get(YQL_url, function (_return){
        stock = _return.query.results.quote;
        Ask = stock.Ask;
		Bid = stock.Bid;
		Change = stock.Change;
		PerChange = stock.PercentChange;
		Volume = stock.AverageDailyVolume;
		Price = stock.LastTradePriceOnly;
        return Ask.toString(), Bid.toString(), Change.toString, PerChange.toString(), Volume.toString(), Price.toString();
    })).then(function(){
        e.html(Price);
		e.closest('tr').find("td:nth-child(5)").html((Ask));
		e.closest('tr').find("td:nth-child(6)").html((Bid));
		e.closest('tr').find("td:nth-child(7)").html((Change));
		e.closest('tr').find("td:nth-child(8)").html((PerChange));
		e.closest('tr').find("td:nth-child(9)").html((Volume));
    });
}

function getPrices(e){
    var ticker = e.closest('tr').find("td:nth-child(3)").text();
    var bp = e.closest('tr').find("td:nth-child(4)").text();
    var type = e.closest('tr').find("td:nth-child(8)").text();
    var YQL_url = "https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.quotes%20where%20symbol%20in%20(%22" +ticker+ "%22)&format=json&env=store://datatables.org/alltableswithkeys";
    var stock, Bid;
    $.when($.get(YQL_url, function (_return){
        stock = _return.query.results.quote;
        Bid = stock.Bid;
        return Bid.toString();
    })).then(function(){
        e.html(Bid);
        if(type == 'L'){
            e.closest('tr').find("td:nth-child(7)").html((Bid - bp).toFixed(2));
        }else{
            e.closest('tr').find("td:nth-child(7)").html((bp - Bid).toFixed(2));
        }
    });
}
    


var temp;
window.cbfunc = function(html) { temp = html.results[0]; };

var symbol;
var Bid;
var Ask;
var CompName;

/* Works randomly */
$(document).ready(function () {
    $("#tickBox").on("input", function(e) {
        'use strict';
        var tick = document.getElementById("tickBox").value;
        $.ajax({
            type: 'GET',
            url: 'http://d.yimg.com/aq/autoc?query='+ tick + '&region=US&lang=en-US',
            crossOrigin : true,
            success: function(data){
                var stock = JSON.parse(data);
                var res = stock.ResultSet.Result;
                var dropDownHTML;
                for (var i=0; i<res.length ; i++){
                    dropDownHTML = dropDownHTML + '<option value="' + res[i].symbol + '">' + res[i].name + ' ' + res[i].exchDisp + '</option>';
                }
                document.getElementById("options").innerHTML = dropDownHTML;
            }
        });
    });
});

/*Managing Stock Information*/
function StockPriceTicker(st) {
    'use strict';
	if (st) {
		var ticker = st;
	} else {
    	var ticker = document.getElementById("tickBox").value;
	};
    var JSON_url = "http://finance.google.com/finance/info?client=ig&q=NASDAQ%3A" + ticker,
        YQL_url = "https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.quotes%20where%20symbol%20in%20(%22" + ticker + "%22)&format=json&env=store://datatables.org/alltableswithkeys",Price,ChnageInPrice,PercentChnageInPrice,Time,Open,PrevClose,stockhtmlTable,stockhtmlChart,stockhtmlNews,
        Symbol,Ask,Bid,Volume,Exchange,News,
        StockTicker = $.when(
        $.getScript('http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20html%20where%20url%3D%22' + encodeURIComponent(JSON_url) + '%22&format=xml&diagnostics=true&callback=cbfunc', function(){
        temp = temp.split("//");
        temp = temp[1].split("</body>");
        temp = JSON.parse(temp[0]);
        Price = temp[0].l;
        Time = temp[0].lt;
		Exchange = temp[0].e;
        PercentChnageInPrice = temp[0].cp;
        }),
        $.get(YQL_url, function (_return) {
        var stock = _return.query.results.quote;
        CompName = stock.Name;
        Symbol = stock.symbol;
        ChnageInPrice = stock.Change;
        Open = stock.Open;
        PrevClose = stock.PreviousClose;
        Ask = stock.Ask;
        if (Ask == null){
            Ask = 'No Ask Price';
        }
        Bid = stock.Bid;
        if (Bid == null){
            Bid = 'No Bid Price';
        }
        Volume = stock.Volume;
        //Exchange = stock.StockExchange;
        })
        ).then(function(){
            $.ajax({
              url: "https://api.nytimes.com/svc/search/v2/articlesearch.json" + '?' + $.param({ 'api-key':"560936d4535e48dca943183ef5249128", 'q': CompName, 'fq': CompName, 'sort': "newest",'page': 5}),
              //crossOrigin : true,
              method: 'GET',
            }).done(function(News) {
                stockhtmlTable = "<h2 id='tickSym'> Company Name: " + CompName + " (" + ticker + ") </h2>";
                stockhtmlTable = stockhtmlTable + "<table style='width:60%' align='center' id='stockTable'> <tr>";
                stockhtmlTable = stockhtmlTable + "<th><font color='green'>Last Trade Price ($) </font></th>";
                stockhtmlTable = stockhtmlTable + "<th>" + Price + "</th>";
                stockhtmlTable = stockhtmlTable + "<th><font color='green'>Last Trade Time </font></th>";
                stockhtmlTable = stockhtmlTable + "<th>" + Time + "</th></tr>";
                stockhtmlTable = stockhtmlTable + "<tr><th><font color='green'>Change ($) </font></th>";
                stockhtmlTable = stockhtmlTable + "<th>" + ChnageInPrice + "</th>";
                stockhtmlTable = stockhtmlTable + "<th><font color='green'>Percent Change ($) </font></th>";
                stockhtmlTable = stockhtmlTable + "<th>" + PercentChnageInPrice + "% </th></tr>";
                stockhtmlTable = stockhtmlTable + "<tr><th><font color='green'>Open ($) </font></th>";
                stockhtmlTable = stockhtmlTable + "<th>" + Open + "</th>";
                stockhtmlTable = stockhtmlTable + "<th><font color='green'>Previous Close ($)</font></th>";
                stockhtmlTable = stockhtmlTable + "<th>" + PrevClose + "</th></tr>";
                stockhtmlTable = stockhtmlTable + "<tr><th><font color='green'>Ask ($) </font></th>";
                stockhtmlTable = stockhtmlTable + "<th>" + Ask + "</th>";
                stockhtmlTable = stockhtmlTable + "<th><font color='green'>Bid ($)</font> </th>";
                stockhtmlTable = stockhtmlTable + "<th>" + Bid + "</th></tr>";
                stockhtmlTable = stockhtmlTable + "<th><font color='green'> Average Volume </font></th>";
                stockhtmlTable = stockhtmlTable + "<th>" + Volume + "</th>";
                stockhtmlTable = stockhtmlTable + "<th> <font color='green'>Stock Exchange </font></th>";
                stockhtmlTable = stockhtmlTable + "<th>" + Exchange + "</th></tr>";
                stockhtmlTable = stockhtmlTable + "</table><br><br>";                
                document.getElementById("showStockTick").innerHTML = stockhtmlTable;
                
                if(Exchange.includes("MKT")){
                    Exchange = Exchange.replace("MKT","");
                }
                
                var script = document.createElement('script');
                script[(script.innerText===undefined?"textContent":"innerText")] = "new TradingView.widget({ 'width': 770, 'height': 500, 'symbol': '" + Exchange + ":"+ticker+ "','interval': 'D','timezone': 'Etc/UTC','theme': 'White','style': '1','locale': 'en','toolbar_bg': '#f1f3f6','enable_publishing': false,'hide_top_toolbar': true,'save_image': false, 'news': ['headlines'], 'hideideas': true, container_id : 'stockChart'});";
                document.getElementById("stockChart").appendChild(script);
                
                
                /* Start of News */
                stockhtmlNews = "<table class='table table-borderless table-hover table-responsive' style='width:60%' align='center'> <thead class='thead-inverse'><tr><th>Trending In "+CompName+" Through NYT</th></tr></thead><tbody>";
                
                for (var i=0; i< 5 ; i++){
                        stockhtmlNews = stockhtmlNews + "<tr><td><a href="+News.response.docs[i].web_url+">"+News.response.docs[i].headline.main+"</a></td></tr>";
                }
                stockhtmlNews = stockhtmlNews + "</tbody></table>";
                document.getElementById("newsresult").innerHTML = stockhtmlNews;
            });
            
        });
    symbol = ticker;
}


var chart = AmCharts.makeChart( "chartdiv", {
  "type": "xy",
  "theme": "light",
  "dataDateFormat": "YYYY-MM-DD",
  "balloon": {
        "adjustBorderColor": false,
        "shadowAlpha": 0,
        "fixedPosition":true
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
    },
  "dataProvider": chartData,
  "zoomOutOnDataUpdate": false
} );


function Ticker(st){
	if (st) {
		StockPriceTicker(st);
    	StockPriceTicker(st);	
	} else {
    	StockPriceTicker();
    	StockPriceTicker();
		//ForcePrice(); 
	};
}

function view(stock) {
	window.location.href = "profile.php?compName=" + stock;
}

function watchList() {
    symbol = document.getElementById("companySymbol").innerHTML;
    CompName = document.getElementById("companyName").innerHTML;
	window.location.href = "php/watchList.php?symbol=" + symbol + "&compName=" + CompName;
}

function removeWatch(num) {
	window.location.href = "php/removeWatchList.php?orderNum=" + num;
}
