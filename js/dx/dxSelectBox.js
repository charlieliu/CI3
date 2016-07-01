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
    },{
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
    },{
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

$(document).ready(function(){
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
});