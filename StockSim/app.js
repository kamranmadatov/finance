$(function() {
  /* Push the body and the nav over by 285px over */
  $('.icon-menu').click(function() {
    $('.menu').animate({
      left: "0px"
    }, 200);

    $('body').animate({
      left: "90px"
    }, 200);
  });
  
    
  /* Then push them back */
  $('.icon-close').click(function() {
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

$(function(){
    var old = console.log;
    var logger = document.getElementById('result');
    console.log = function (message) {
    if (typeof message == 'object') {
        logger.innerHTML += (JSON && JSON.stringify ? JSON.stringify(message) : message) + '<br />';
        } else {
        logger.innerHTML += message + '<br />';
        }
    }
});

$(function()
{
	$('.scroll-pane').jScrollPane();
});
	

function StockPriceTicker() {
    'use strict';
    var ticker = document.getElementById("tickBox").value,
        YQL_url = "https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.quotes%20where%20symbol%20in%20(%22" + ticker + "%22)&format=json&env=store://datatables.org/alltableswithkeys",
        StockTickerHTML = "",
        CompName,
        Price,
        ChnageInPrice,
        PercentChnageInPrice,
        Time,
        Open,
        PrevClose,
        stockhtmlTable,
        stockhtmlChart,
        Symbol,
        Ask,
        Bid,
        Volume,
        Exchange,
        
        StockTickerXML = $.get(YQL_url, function (_return) {
            var stock = _return.query.results.quote;
            CompName = stock.Name;
            Symbol = stock.symbol;
            Price = stock.LastTradePriceOnly;
            Time = stock.LastTradeTime;
            ChnageInPrice = stock.Change;
            PercentChnageInPrice = stock.Change_PercentChange;
            Open = stock.Open;
            PrevClose = stock.PreviousClose;
            Ask = stock.Ask;
            Bid = stock.Bid;
            Volume = stock.Volume;
            Exchange = stock.StockExchange;
            
            stockhtmlTable = "<h2> Company Name: " + CompName + " (" + Symbol + ") </h2>";
            stockhtmlTable = stockhtmlTable + "<table style='width:35%' align='center'> <tr>";
            stockhtmlTable = stockhtmlTable + "<th>Last Trade Price ($):</th>";
            stockhtmlTable = stockhtmlTable + "<th>" + Price + "</th>";
            stockhtmlTable = stockhtmlTable + "<th>Last Trade Time:</th>";
            stockhtmlTable = stockhtmlTable + "<th>" + Time + "</th></tr>";
            stockhtmlTable = stockhtmlTable + "<tr><th>Change ($):</th>";
            stockhtmlTable = stockhtmlTable + "<th>" + ChnageInPrice + "</th>";
            stockhtmlTable = stockhtmlTable + "<th>Percent Change ($):</th>";
            stockhtmlTable = stockhtmlTable + "<th>" + PercentChnageInPrice + "</th></tr>";
            stockhtmlTable = stockhtmlTable + "<tr><th>Open ($):</th>";
            stockhtmlTable = stockhtmlTable + "<th>" + Open + "</th>";
            stockhtmlTable = stockhtmlTable + "<th>Previous Close ($):</th>";
            stockhtmlTable = stockhtmlTable + "<th>" + PrevClose + "</th></tr>";
            stockhtmlTable = stockhtmlTable + "<tr><th>Ask ($):</th>";
            stockhtmlTable = stockhtmlTable + "<th>" + Ask + "</th>";
            stockhtmlTable = stockhtmlTable + "<th>Bid ($):</th>";
            stockhtmlTable = stockhtmlTable + "<th>" + Bid + "</th></tr>";
            stockhtmlTable = stockhtmlTable + "<th>Volume (shares) :</th>";
            stockhtmlTable = stockhtmlTable + "<th>" + Volume + "</th>";
            stockhtmlTable = stockhtmlTable + "<th> Stock Exchange :</th>";
            stockhtmlTable = stockhtmlTable + "<th>" + Exchange + "</th></tr>";
            stockhtmlTable = stockhtmlTable + "</table><br>";
            stockhtmlTable = stockhtmlTable + "<button style=\"background-color: green;border: none;color: white;text-align: center;padding: 5px 20px;font-size: 16px;\" onclick=\"insert1D('" + Symbol + "')\" id='1DButton' class='tickButton'>1D</button>";
            stockhtmlTable = stockhtmlTable + "<button style=\"background-color: green;border: none;color: white;text-align: center;padding: 5px 20px;font-size: 16px;\" onclick=\"insert5D('" + Symbol + "')\" id='5DButton' class='tickButton'>5D</button>";
            stockhtmlTable = stockhtmlTable + "<button style=\"background-color: green;border: none;color: white;text-align: center;padding: 5px 20px;font-size: 16px;\" onclick=\"insert1M('" + Symbol + "')\" id='1MButton' class='tickButton'>1M</button>";
            stockhtmlTable = stockhtmlTable + "<button style=\"background-color: green;border: none;color: white;text-align: center;padding: 5px 20px;font-size: 16px;\" onclick=\"insert6M('" + Symbol + "')\" id='6MButton' class='tickButton'>6M</button>";
            stockhtmlTable = stockhtmlTable + "<button style=\"background-color: green;border: none;color: white;text-align: center;padding: 5px 20px;font-size: 16px;\" onclick=\"insert1Y('" + Symbol + "')\" id='1YButton' class='tickButton'>1Y</button>";
            stockhtmlTable = stockhtmlTable + "<button style=\"background-color: green;border: none;color: white;text-align: center;padding: 5px 20px;font-size: 16px;\" onclick=\"insert2Y('" + Symbol + "')\" id='2YButton' class='tickButton'>2Y</button>";
            stockhtmlTable = stockhtmlTable + "<button style=\"background-color: green;border: none;color: white;text-align: center;padding: 5px 20px;font-size: 16px;\" onclick=\"insert5Y('" + Symbol + "')\" id='5YButton' class='tickButton'>5Y</button>";
            stockhtmlTable = stockhtmlTable + "<button style=\"background-color: green;border: none;color: white;text-align: center;padding: 5px 20px;font-size: 16px;\" onclick=\"insert9Y('" + Symbol + "')\" id='9YButton' class='tickButton'>9Y</button>";
  				
            document.getElementById("showStockTick").innerHTML = stockhtmlTable;
            insert6M(Symbol);
            
    });
    
}


function insert1D(Symbol) {
    insertChart(Symbol,"1d");
}

function insert5D(Symbol) {
    insertChart(Symbol,"5d");
}

function insert1M(Symbol) {
    insertChart(Symbol,"1m");
}

function insert6M(Symbol) {
    insertChart(Symbol,"6m");
}

function insert1Y(Symbol) {
    insertChart(Symbol,"1y");
}

function insert2Y(Symbol) {
    insertChart(Symbol,"2y");
}

function insert5Y(Symbol) {
    insertChart(Symbol,"5y");
}

function insert9Y(Symbol) {
    insertChart(Symbol,"9y");
}

function insertChart(Symbol,length) {
    insertImage = "<img src='https://chart.finance.yahoo.com/z?s=" + Symbol + "&t=" + length + "&q=l&l=on&z=s&p=m50,m200'/>";
    document.getElementById("stockChart").innerHTML = insertImage;
}

