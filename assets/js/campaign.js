var reportID = '#all';
var expire = 60000; // once a minute
var refreshInterval = '';

function setRefresh(expire) {
    console.log('current refresh rate: ' + expire);
    refreshInterval = setInterval(function(){loadReport(reportID);},expire);
}

$(document).ready(function() {
    loadReport(reportID);
    setRefresh(expire);
});

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    reportID = (e.target['hash']);
    loadReport(reportID);
})

$("#update").click(function () {
    var tmp = $("#expire").val();
    if (tmp >= 5) {
        expire = tmp * 1000;
    } else {
        expire = 5000;
    }
    $("#expire").val(expire / 1000);
    clearInterval(refreshInterval);
    setRefresh(expire);
    loadReport(reportID);
});

$("#stop").click(function () {
    clearInterval(refreshInterval);
});
