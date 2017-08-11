/* Created by Ryan Schnarrs */

var ravers;

// Increment function done by Charlie
function increment(name, user, spanId)
{ //used for getting user, span id so function can be reused
    //global vars used for notify()
    note = $(spanId);
    statName = name;

    var amount = $(statName).value;
    var id = $(statName).name;

    console.log(name);

    //value is hard coded but will come from session vars in BB php
    //var user= 1;

    //AJAX REQUEST
    new Ajax.Request("backend/update_stats.php",{

        method: "POST",
        parameters: {userId:user, statAmount:amount, statId:id},
        onSuccess: notify

    });
}

function notify(ajax)
{
    note.innerHTML = "++ "+statName+" is increased by "+ajax.responseText;
    ravers = setInterval("raveTitle()",40);
    setTimeout("changeCSS()",999);
}

function raveTitle()
{
    document.getElementById("header").style.color = randomColorGenerator();
}

function changeCSS()
{
    note.innerHTML = "";
    clearInterval(ravers);
    document.getElementById("header").style.color = "black";
}

function randomColorGenerator()
{

    var letters = '0123456789ABCDEF';
    var color = '#';

    for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }

    return color;
}