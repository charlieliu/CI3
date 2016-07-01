var accordionItems  = [{
    "ID": 1,
    "CompanyName": "Super Mart of the West",
    "Address": "702 SW 8th Street",
    "City": "Bentonville",
    "State": "Arkansas",
    "Zipcode": 72716,
    "Phone": "(800) 555-2797",
    "Fax": "(800) 555-2171",
    "Website": "http://www.nowebsitesupermart.com"
}, {
    "ID": 2,
    "CompanyName": "Electronics Depot",
    "Address": "2455 Paces Ferry Road NW",
    "City": "Atlanta",
    "State": "Georgia",
    "Zipcode": 30339,
    "Phone": "(800) 595-3232",
    "Fax": "(800) 595-3231",
    "Website": "http://www.nowebsitedepot.com"
}, {
    "ID": 3,
    "CompanyName": "K&S Music",
    "Address": "1000 Nicllet Mall",
    "City": "Minneapolis",
    "State": "Minnesota",
    "Zipcode": 55403,
    "Phone": "(612) 304-6073",
    "Fax": "(612) 304-6074",
    "Website": "http://www.nowebsitemusic.com"
}, {
    "ID": 4,
    "CompanyName": "Tom's Club",
    "Address": "999 Lake Drive",
    "City": "Issaquah",
    "State": "Washington",
    "Zipcode": 98027,
    "Phone": "(800) 955-2292",
    "Fax": "(800) 955-2293",
    "Website": "http://www.nowebsitetomsclub.com"
}];

$(document).ready(function(){
    DevExpress.ui.setTemplateEngine("underscore");

    var tagBox = $("#tagbox").dxTagBox({
        dataSource: accordionItems,
        displayExpr: "CompanyName",
        disabled: true,
        value: [accordionItems[0]],
        onValueChanged: function(e) {
            accordion.option("selectedItems", e.value)
        }
    }).dxTagBox("instance");

    var accordion = $("#accordion-container").dxAccordion({
        dataSource: accordionItems,
        itemTemplate: "customer",
        animationDuration: 300,
        collapsible: false,
        multiple: false,
        selectedItems: [accordionItems[0]],
        itemTitleTemplate: $("#title"),
        itemTemplate: $("#customer"),
        onSelectionChanged: function(e) {
            tagBox.option("value", e.component.option("selectedItems"));
        }
    }).dxAccordion("instance");

    $("#slider").dxSlider({
        min: 0,
        max: 1000,
        value: 300,
        label: { visible: true},
        tooltip: {
            enabled: true,
            position: "bottom"
        },
        onValueChanged: function(e) {
            accordion.option("animationDuration", e.value);
        }
    });

    $("#multiple-enabled").dxCheckBox({
        text: "Multiple enabled",
        onValueChanged: function(e) {
            accordion.option("multiple", e.value);
            tagBox.option("disabled", !e.value);
            tagBox.option("value", accordion.option("selectedItems"));
        }
    });

    $("#collapsible-enabled").dxCheckBox({
        text: "Collapsible enabled",
        onValueChanged: function(e) {
            accordion.option("collapsible", e.value);
        }
    });
});