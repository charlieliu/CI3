$(document).ready(function(){
    $("#date").dxDateBox({
        type: "date"
    });

    $("#time").dxDateBox({
        type: "time"
    });

    $("#date-time").dxDateBox({
        type: "datetime"
    });

    $("#custom").dxDateBox({
        displayFormat: "EEEE, MMM dd"
    });

    $("#date-by-picker").dxDateBox({
        pickerType: "rollers"
    });

    $("#disabled").dxDateBox({
        type: "datetime",
        disabled: true
    });

    $("#clear").dxDateBox({
        type: "time",
        showClearButton: true,
        value: new Date(2015, 12, 1, 6)
    });

    var startDate = new Date(1981, 3, 27);

    $("#birthday").dxDateBox({
        applyValueMode: "useButtons",
        value: startDate,
        max: new Date(),
        min: new Date(1900, 0, 1),
        onContentReady: function() {
            dateDiff(startDate);
        },
        onValueChanged: function(data) {
            dateDiff(new Date(data.value));
        }
    });

    function dateDiff(secondDate) {
        var diffInDay = Math.floor(Math.abs((new Date() - secondDate)/(24*60*60*1000)));
        return $("#age").text(diffInDay + " days");
    }
});