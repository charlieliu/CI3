$(document).ready(function(){
    $("#checked").dxCheckBox({
        value: true
    });

    $("#unchecked").dxCheckBox({
        value: false
    });

    $("#indeterminate").dxCheckBox({
        value: undefined
    });

    $("#handler").dxCheckBox({
        value: undefined,
        onValueChanged: function(data) {
            console.log(data);
            disabledCheckbox.option("value", data.value);
        },
        onInitialized: function(data) {
            console.log(data);
        }
    });

    var disabledCheckbox = $("#disabled").dxCheckBox({
        value: undefined,
        disabled: true
    }).dxCheckBox("instance");

    $("#withText").dxCheckBox({
        value: true,
        width: 80,
        text: "Check"
    });
});