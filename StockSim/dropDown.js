$(document).ready(function() {
    $("#tickBox").on("input", function(e) {
        'use strict';
        var tick = document.getElementById("tickBox").value;
        $.get("http://d.yimg.com/aq/autoc?query="+ tick +"&region=US&lang=en-US", function(data) {
        //$.get("https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.quotes%20where%20symbol%20in%20(%22" + tick + "%22)&format=json&env=store://datatables.org/alltableswithkeys", function(data) {
        //$.getJSON("http://stocksearchapi.com/api/?search_text=" + tick + "&api_key=1374a1ba5dcb4ac199361c5f5e36b9cef5bd6bed", function(data) {
            var dropDownHTML;
            var stock = data.ResultSet;
            for (var i = 0; i < stock.Result.length ;i++){
                //dropDownHTML = dropDownHTML + '<option value="' + data[i].company_symbol + '">' + data[i].company_name + '</option>';
                dropDownHTML = dropDownHTML + '<option value="' + stock.Result[i].symbol + '">' + stock.Result[i].name + '</option>';
            }
            document.getElementById("options").innerHTML = dropDownHTML;
        });
    });
})

/*
{"ResultSet":
    {"Query":"tlo","Result":
    [{"symbol":"TLO","name":"SPDR Blmbg Barclays Long Term Trs ETF","exch":"PCX","type":"E","exchDisp":"NYSEArca","typeDisp":"ETF"},{"symbol":"TLOG","name":"TetraLogic Pharmaceuticals Corporation","exch":"NMS","type":"S","exchDisp":"NASDAQ","typeDisp":"Equity"},{"symbol":"TLO.TO","name":"Talon Metals Corp.","exch":"TOR","type":"S","exchDisp":"Toronto","typeDisp":"Equity"},{"symbol":"TLO.A","name":"TLO.A","exch":"ASE","type":"E","exchDisp":"NYSE MKT","typeDisp":"ETF"},
    {"symbol":"TLOFF","name":"Talon Metals Corp.","exch":"PNK","type":"S","exchDisp":"OTC Markets","typeDisp":"Equity"},{"symbol":"TLOU.L","name":"Tlou Energy Limited","exch":"LSE","type":"S","exchDisp":"London","typeDisp":"Equity"},{"symbol":"TOU.AX","name":"Tlou Energy Limited","exch":"ASX","type":"S","exchDisp":"Australian","typeDisp":"Equity"},
    {"symbol":"^TLO-EU","name":"SPDR Bloomberg Barclays Long Te","exch":"ASE","type":"I","exchDisp":"NYSE MKT","typeDisp":"Index"},{"symbol":"^TLO-IV","name":"SPDR Bloomberg Barclays Long Te","exch":"ASE","type":"I","exchDisp":"NYSE MKT","typeDisp":"Index"},{"symbol":"^TLO-NV","name":"SPDR Bloomberg Barclays Long Te","exch":"ASE","type":"I","exchDisp":"NYSE MKT","typeDisp":"Index"}]}}


*/