var validationGroup = 'SampleGroup';
var selectBoxData = [{
        "name": "嘉義",
        "capital": "CYI ",
        "en_name":"CHIAYI"
    },{
        "name": "七美",
        "capital": "CMJ",
        "en_name":"CHIMAY"
    },{
        "name": "綠島",
        "capital": "GNI",
        "en_name":"GREEN ISLAND"
    },{
        "name": "花蓮",
        "capital": "HUN",
        "en_name":"HUALIEN"
    },{
        "name": "高雄",
        "capital": "KHH",
        "en_name":"KAOHSIUNG"
    },{
        "name": "金門",
        "capital": "KNH",
        "en_name":"KINMEN"
    },{
        "name": "蘭嶼",
        "capital": "KYD",
        "en_name":"ORCHID ISLAND"
    },    {
        "name": "馬公",
        "capital": "MZG",
        "en_name":"MAKUNG"
    },{
        "name": "馬祖",
        "capital": "MFK",
        "en_name":"MATSU"
    },{
        "name": "屏東",
        "capital": "PIF",
        "en_name":"PINGTUNG"
    },{
        "name": "台南",
        "capital": "TNN",
        "en_name":"TAINAN"
    },{
        "name": "松山",
        "capital": "TSA",
        "en_name":"SUNG SHAN"
    },
    {
        "name": "台東",
        "capital": "TTT",
        "en_name":"TAITUNG"
    },{
        "name": "台中",
        "capital": "TXG",
        "en_name":"TAICHUNG"
    },{
        "name": "望安",
        "capital": "WOT",
        "en_name":"WON-AN"
    }];
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
var windowresize = function(){
    $('.dx-field-label').css('max-width', '200px').css('min-width', '120px');
    var w1 = parseInt($('.dx-field').css('width').substr(0,($('.dx-field').css('width').length)-2)),
        w2 = parseInt($('.dx-field-label').css('width').substr(0,($('.dx-field-label').css('width').length)-2)),
        w3 = w1-w2;
    if (w3 < 200) w3 = 200;
    $('.dx-field-value').css('width', w3+'px' );
};
$(document).ready(function(){

    $('#login').dxTextBox({
        value: '',
        placeholder: 'User name',
        onValueChanged: function(e){
            console.log(e);
        }
    }).dxValidator({
        name: 'Login',
        validationGroup: validationGroup,
        validationRules: [{
            type: 'required'
        },{
            type: 'pattern',
            pattern: '^[a-zA-Z0-9]+$',
            message: 'Do not use digits in the User name field'
        },{
            type: 'stringLength',
            min: 4
        }]
    });
    $('#password').dxTextBox({
        mode: 'password',
        placeholder: 'Password',
        onValueChanged: function(e){
            console.log(e);
        }
    }).dxValidator({
        name: 'Password',
        validationGroup: validationGroup,
        validationRules: [{
            type: 'required',
            trim: true
        },{
            type: 'stringLength',
            min: 8
        }]
    });
    $('#email').dxTextBox({
        value: '',
        placeholder: 'Email',
        onValueChanged: function(e){
            console.log(e);
        }
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
            console.log(params);
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
        step: 5,
        onValueChanged: function(e){
            console.log(e);
        }
    }).dxValidator({
        name: 'Number',
        validationGroup: validationGroup,
        validationRules: [{
            type: 'required'
        }, {
            type: 'range',
            reevaluate: true,
            min: 60,
            max: 100,
            message: 'Number is out of range'
        }]
    });

    $("#selectBox").dxSelectBox({
        dataSource: selectBoxData,
        valueExpr: 'capital',
        displayExpr: 'name',
        onValueChanged: function(e){
            console.log(e.itemData.en_name);
        }
    }).dxValidator({
        name: 'selectBox',
        validationGroup: validationGroup,
        validationRules: [{
            type: 'required'
        }]
    });

    $("#colorBox").dxColorBox({
        value: 'rgba(255, 144, 0, 0.3)',
        editAlphaChannel: true,
        onValueChanged: function(e){
            console.log(e);
        }
    });

    $("#textArea").dxTextArea({
        value: '',
        placeholder: 'Text displayed by the widget',
        maxLength: 300,
        height: 400,
        onValueChanged: function(e){
            console.log(e);
        }
    }).dxValidator({
        name: 'textArea',
        validationGroup: validationGroup,
        validationRules: [{
            type: 'required'
        }]
    });

    $("#radio-group-simple").dxRadioGroup({
        items: priorities,
        value: priorities[0],
        onValueChanged: function(e){
            console.log(e);
        }
    });

    $("#radio-group-disabled").dxRadioGroup({
        items: priorities,
        value: priorities[1],
        disabled: true,
        onValueChanged: function(e){
            console.log(e);
        }
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
            console.log(e);
            $("#list").children().remove();
            $.each(tasks, function(i, item){
                if(priorities[item.priorityIndex] == e.value)
                {
                    $("#list").append($("<li/>").text(tasks[i].subject));
                }
            });
        },
        onOptionChanged: function(e){
            console.log(e);
        },
        onInitialized: function(){
            var this_value = this._options.value;
            $("#list").children().remove();
            $.each(tasks, function(i, item){
                if(priorities[item.priorityIndex] == this_value)
                {
                    $("#list").append($("<li/>").text(tasks[i].subject));
                }
            });
        }
    });

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
    });

    $("#fileUploader").dxFileUploader({
        name: 'fileUploader',
        buttonText: 'Select file',
        labelText: 'Drop file here',
        multiple: true,
        accept: 'image/*'
    }).dxValidator({
        name: 'fileUploader',
        validationGroup: validationGroup,
        validationRules: [{
            type: 'required'
        }]
    });

    windowresize();

    $(window).resize(function(){
        windowresize();
    });
})