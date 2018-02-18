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