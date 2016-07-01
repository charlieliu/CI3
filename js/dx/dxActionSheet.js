var contacts = [
        { name: "Barbara J. Coggins", phone: "512-964-2757", email: "BarbaraJCoggins@rhyta.com", category: "Family" },
        { name: "Leslie S. Alcantara", phone: "360-684-1334", email: "LeslieSAlcantara@teleworm.us", category: "Friends" },
        { name: "Chad S. Miles", phone: "520-573-7903", email: "ChadSMiles@rhyta.com", category: "Work" },
        { name: "Michael A. Blevins", phone: "530-480-1961", email: "MichaelABlevins@armyspy.com", category: "Work" },
        { name: "Jane K. Hernandez", phone: "404-781-0805", email: "JaneKHernandez@teleworm.us", category: "Friends" },
        { name: "Kim D. Thomas", phone: "603-583-9043", email: "KimDThomas@teleworm.us", category: "Work" },
        { name: "Donald L. Jordan", phone: "772-766-2842", email: "DonaldLJordan@dayrep.com", category: "Family" },
        { name: "Nicole A. Rios", phone: "213-812-8400", email: "NicoleARios@armyspy.com", category: "Friends" },
        { name: "Barbara M. Roberts", phone: "614-365-7945", email: "BarbaraMRoberts@armyspy.com", category: "Friends" }
];

var enableTimeout;

$(document).ready(function(){

    function showAlert(value) {
        DevExpress.ui.dialog.alert("The \"" + 
            value + "\" button is clicked.", "Click Handler");
    };

    $("#show-title").dxSwitch({
        value: true,
        onValueChanged: function(e) {
            actionSheet.option("showTitle", e.value);
        }
    });

    $("#show-cancelbutton").dxSwitch({
        value: true,
        onValueChanged: function(e) {
            actionSheet.option("showCancelButton", e.value);
        }
    });


    $("#use-popover").dxSwitch({
        value: false,
        onValueChanged: function(e) {
            actionSheet.option("usePopover", e.value);
        }
    });

    $("#disabled").dxSwitch({
        value: false,
        onValueChanged: function(e) {
            actionSheet.option("disabled", e.value);
        }
    });

    $("#list").dxList({
        dataSource: contacts,
        itemTemplate: function(itemData, itemIndex, itemElement) {
            itemElement.append(
                $("<div />").text(itemData.name),
                $("<div />").text(itemData.phone),
                $("<div />").text(itemData.email)
            );
        },
        onItemClick: function(e) {
            clearTimeout(enableTimeout);
            actionSheet.option("target", e.itemElement);
            actionSheet.option("visible", true);
            enableTimeout = setTimeout(function() {
                actionSheet.option("disabled", false);
            }, 5000);
        }
    });

    var actionSheet = $("#action-sheet").dxActionSheet({
        dataSource: [
            { text: "Call" },
            { text: "Send message" },
            { text: "Edit" },
            { text: "Delete" }
        ],
        title: "Choose action",
        target: "",
        onCancelClick: function() {
            showAlert("Cancel");
        },
        onItemClick: function(value) {
            showAlert(value.itemData.text);
        },
        visible: false,
        showTitle: true,
        disabled: false,
        usePopover: false,
        showCancelButton: true
    }).dxActionSheet("instance");
});