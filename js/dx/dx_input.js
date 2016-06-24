var windowresize = function(){
    $('.dx-field-label').css('max-width', '200px').css('min-width', '120px');
    var w1 = parseInt($('.dx-field').css('width').substr(0,($('.dx-field').css('width').length)-2)),
        w2 = parseInt($('.dx-field-label').css('width').substr(0,($('.dx-field-label').css('width').length)-2)),
        w3 = w1-w2;
    if (w3 < 200) w3 = 200;
    $('.dx-field-value').css('width', w3+'px' );
};
$(document).ready(function(){
    var validationGroup = 'SampleGroup';
    $('#login').dxTextBox({
        value: '',
        placeholder: 'User name'
    }).dxValidator({
        name: 'Login',
        validationGroup: validationGroup,
        validationRules: [{
            type: 'required'
        }, {
            type: 'pattern',
            pattern: '^[a-zA-Z0-9]+$',
            message: 'Do not use digits in the User name field'
        }, {
            type: 'stringLength',
            min: 4
        }]
    });
    $('#password').dxTextBox({
        mode: 'password',
        placeholder: 'Password'
    }).dxValidator({
        name: 'Password',
        validationGroup: validationGroup,
        validationRules: [{
            type: 'required',
            trim: true
        }, {
            type: 'stringLength',
            min: 8
        }]
    });
    $('#email').dxTextBox({
        value: '',
        placeholder: 'Email'
    }).dxValidator({
        name: 'Email',
        validationGroup: validationGroup,
        validationRules: [{
            type: 'required'
        }, {
            type: 'email',
            message: 'You are logged in by the "'+$('#email').dxTextBox('instance').option('value')+'" email'
        }]
    });
    $('#button').dxButton({
        text: "Submit",
        validationGroup: validationGroup,
        onClick: function(params){
            var result = params.validationGroup.validate();
            if (result.isValid)
            {
                DevExpress.ui.notify({
                    message: 'You are logged in as ' + $('#login').dxTextBox('instance').option('value'),
                    position: {
                        at: 'right top',
                        my: 'right top'
                    }
                }, 'success', 3000);
            }
        }
    });
    $('#summary').dxValidationSummary({
        validationGroup: validationGroup
    });
    $("#numberBox").dxNumberBox({
        min: -100,
        max: 100,
        showSpinButtons: true,
        step: 5
    }).dxValidator({
        name: 'Number',
        validationGroup: validationGroup,
        validationRules: [{
            type: 'required'
        }, {
            type: 'range',
            reevaluate: true,
            min: -5,
            max: 5,
            message: 'Value is out of range'
        }]
    });
   var selectBoxData = [
        { "name": "Alabama", "capital": "Montgomery" },
        { "name": "Alaska", "capital": "Juneau" },
        { "name": "Arizona", "capital": "Phoenix" }
    ]
    $("#selectBox").dxSelectBox({
        dataSource: selectBoxData,
        valueExpr: 'capital',
        displayExpr: 'name'
    });
    $("#colorBox").dxColorBox({
        value: 'rgba(255, 144, 0, 0.3)',
        editAlphaChannel: true
    });
    $("#textArea").dxTextArea({
        value: '',
        placeholder: 'Text displayed by the widget',
        maxLength: 300,
        height: 400
    });
    var priorities = ["Low", "Normal", "Urgent", "High"],
        tasks = [{
            id: 1,
            subject: "Choose between PPO and HMO Health Plan",
            assignedEmployeeId: 1,
            priorityIndex: 3
        }, {
            id: 2,
            subject: "Non-Compete Agreements",
            assignedEmployeeId: 2,
            priorityIndex: 0
        }, {
            id: 3,
            subject: "Comment on Revenue Projections",
            assignedEmployeeId: 2,
            priorityIndex: 1
        }, {
            id: 4,
            subject: "Sign Updated NDA",
            assignedEmployeeId: 3,
            priorityIndex: 2
        }, {
            id: 5,
            subject: "Submit Questions Regarding New NDA",
            assignedEmployeeId: 6,
            priorityIndex: 3
        }, {
            id: 6,
            subject: "Rollout of New Website and Marketing Brochures",
            assignedEmployeeId: 22,
            priorityIndex: 3
        }];
    $("#radio-group-simple").dxRadioGroup({
        items: priorities,
        value: priorities[0]
    });

    $("#radio-group-disabled").dxRadioGroup({
        items: priorities,
        value: priorities[1],
        disabled: true
    });

    $("#radio-group-change-layout").dxRadioGroup({
        items: priorities,
        value: priorities[1],
        layout: "horizontal",
         onValueChanged: function(e){
            $("#radio-group-disabled").dxRadioGroup({value: e.value}).dxRadioGroup("instance");
        }
    });

    $("#radio-group-with-template").dxRadioGroup({
        items: priorities,
        value: priorities[2],
        itemTemplate: function(itemData, _, itemElement){
            itemElement.parent().addClass(itemData.toLowerCase()).text(itemData);
        },
        onValueChanged: function(e){
            // console.log(e);
            $("#list").children().remove();
            $.each(tasks, function(i, item){
                if(priorities[item.priorityIndex] == e.value){
                    $("#list").append($("<li/>").text(tasks[i].subject));
                }
            });
        },
        onOptionChanged: function(e){
            // console.log(e);
        },
        onInitialized: function(){
            var this_value = this._options.value;
            $("#list").children().remove();
            $.each(tasks, function(i, item){
                if(priorities[item.priorityIndex] == this_value){
                    $("#list").append($("<li/>").text(tasks[i].subject));
                }
            });
        }
    });

    windowresize();

    $(window).resize(function(){
        windowresize();
    });
})