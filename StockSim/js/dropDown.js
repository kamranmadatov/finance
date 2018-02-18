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