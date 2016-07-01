var validationGroup = 'SampleGroup';

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