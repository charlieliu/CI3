var names = ["James", "John", "Robert", "Michael", "William", "David", "Richard", "Charles", "Joseph", "Thomas", "Christopher", "Daniel", "Paul", "Mark", "Donald", "George", "Kenneth", "Steven", "Edward", "Brian", "Ronald", "Anthony", "Kevin", "Jason", "Jeff", "Mary", "Patricia", "Linda", "Barbara", "Elizabeth", "Jennifer", "Maria", "Susan", "Margaret", "Dorothy", "Lisa", "Nancy", "Karen", "Betty", "Helen", "Sandra", "Donna", "Carol", "Ruth", "Sharon", "Michelle", "Laura", "Sarah", "Kimberly", "Deborah"];
var surnames = ["Anderson", "Smith", "Johnson", "Williams", "Jones", "Brown", "Davis", "Miller", "Wilson", "Moore", "Taylor", "Thomas", "Jackson", "White", "Harris", "Martin", "Thompson", "Garcia", "Martinez", "Robinson", "Clark", "Rodriguez", "Lewis", "Lee",
    "Walker", "Hall", "Allen", "Young", "Hernandez", "King", "Wright", "Lopez", "Hill", "Scott", "Green", "Adams", "Baker", "Gonzalez", "Nelson", "Carter", "Mitchell", "Perez", "Roberts", "Turner", "Phillips", "Campbell",
    "Parker", "Evans", "Edwards", "Collins"
];

var positions = ["CEO", "COO", "CTO", "CMO", "HR Manager", "IT Manager", "Controller", "Sales Manager", "Support Manager"];

var cities = ["New York", "Los Angeles", "Chicago", "Houston", "Philadelphia", "Phoenix", "San Antonio", "San Diego", "Dallas", "San Jose", "Austin", "Indianapolis", "Jacksonville", "San Francisco", "Columbus", "Charlotte", "Fort Worth", "Detroit", "El Paso", "Memphis", "Seattle", "Denver", "Washington", "Boston", "Nashville", "Baltimore", "Oklahoma City", "Louisville", "Portland", "Las Vegas", "Milwaukee", "Albuquerque", "Tucson", "Fresno", "Sacramento", "Long Beach", "Kansas City", "Mesa", "Virginia Beach", "Atlanta", "Colorado Springs", "Omaha", "Raleigh", "Miami", "Oakland", "Minneapolis", "Tulsa", "Cleveland", "Wichita", "Arlington", "New Orleans", "Bakersfield", "Tampa", "Honolulu", "Aurora", "Anaheim", "Santa Ana", "St. Louis", "Riverside", "Corpus Christi", "Lexington", "Pittsburgh", "Anchorage", "Stockton", "Cincinnati", "Saint Paul", "Toledo", "Greensboro", "Newark", "Plano", "Henderson", "Lincoln", "Buffalo", "Jersey City", "Chula Vista", "Fort Wayne", "Orlando", "St. Petersburg", "Chandler", "Laredo", "Norfolk", "Durham", "Madison", "Lubbock", "Irvine", "Winston–Salem", "Glendale", "Garland", "Hialeah", "Reno", "Chesapeake", "Gilbert", "Baton Rouge", "Irving", "Scottsdale", "North Las Vegas", "Fremont", "Boise", "Richmond"];

var enableTimeout;

$(document).ready(function(){

    var firstName = "",
        lastName = "",
        position = positions[0],
        city = "",
        state = "";

    $("#first-name").dxAutocomplete({
        dataSource: names,
        placeholder: "Type first name...",
        onValueChanged: function(data) {
            firstName = data.value;
            updateEmployeeInfo();
        }
    });

    $("#last-name").dxAutocomplete({
        dataSource: surnames,
        placeholder: "Type last name...",
        showClearButton: true,
        onValueChanged: function(data) {
            lastName = data.value;
            updateEmployeeInfo();
        }
    });

    $("#position").dxAutocomplete({
        dataSource: positions,
        value: positions[0],
        disabled: true,
        onValueChanged: function(data) {
            position = data.value;
            updateEmployeeInfo();
        }
    });

    $("#city").dxAutocomplete({
        dataSource: cities,
        minSearchLength: 2,
        searchTimeout: 500,
        placeholder: "Type two symbols to search...",
        onValueChanged: function(data) {
            city = data.value;
            updateEmployeeInfo();
        }
    });

    $("#state").dxAutocomplete({
        // dataSource: new DevExpress.data.ODataStore({
        //     url: "http://js.devexpress.com/Demos/DevAV/odata/States?$select=Sate_ID,State_Long,State_Short",
        //     key: "Sate_ID",
        //     keyType: "Int32"
        // }),
        dataSource: cities,
        placeholder: "Type state name...",
        valueExpr: "State_Long",
        itemTemplate: function(data) {
            return $("<div>" + data.State_Long +
                " (" + data.State_Short + ")" + "</div>");
        },
        onValueChanged: function(data) {
            state = data.value;
            updateEmployeeInfo();
        }
    });

    function updateEmployeeInfo() {
        var result = $.trim((firstName || "") + " " + (lastName || ""));

        result += (result && position) ? (", " + position) : position;
        result += (result && city) ? (", " + city) : city;
        result += (result && state) ? (", " + state) : state;

        $("#employee-data").text(result);
    }
});