var priorities = ["Low", "Normal", "Urgent", "High"],
    tasks = [{
        id: 1,
        subject: "Choose between PPO and HMO Health Plan",
        assignedEmployeeId: 1,
        priorityIndex: 3
    },{
        id: 2,
        subject: "Non-Compete Agreements",
        assignedEmployeeId: 2,
        priorityIndex: 0
    },{
        id: 3,
        subject: "Comment on Revenue Projections",
        assignedEmployeeId: 2,
        priorityIndex: 1
    },{
        id: 4,
        subject: "Sign Updated NDA",
        assignedEmployeeId: 3,
        priorityIndex: 2
    },{
        id: 5,
        subject: "Submit Questions Regarding New NDA",
        assignedEmployeeId: 6,
        priorityIndex: 3
    },{
        id: 6,
        subject: "Rollout of New Website and Marketing Brochures",
        assignedEmployeeId: 22,
        priorityIndex: 3
    }];

$(document).ready(function(){
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
});