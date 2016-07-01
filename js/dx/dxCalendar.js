var validationGroup = 'SampleGroup';

$(document).ready(function(){
    $("#calendar").dxCalendar({
        min: new Date(2000,1,1),
        max: new Date(),
        // value: new Date(),
        firstDayOfWeek: 0,
        showTodayButton: true,
        activeStateEnabled: true,
        onValueChanged: function(e){
            console.log(e.value);
        }
    }).dxValidator({
        name: 'calendar',
        validationGroup: validationGroup,
        validationRules: [{
            type: 'required'
        }]
    }).css('margin','2%');
});