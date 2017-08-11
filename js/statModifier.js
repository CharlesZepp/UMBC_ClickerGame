/*Done by Logan Wes*/

function addOption() {
    var i = document.getElementById("counter").value;
    if(i <= 1) {
        // Stat text stat
        var span = document.createElement("span");
        span.innerHTML = "Stat: ";
        document.getElementById("container").appendChild(span);
        // Creates dropdown menu
        var element = document.createElement("select");
        // Create unique id for dropdown menu
        element.name = "stat" + i;
        document.getElementById("counter").value = parseInt(i) + 1;
        
        // Create options
        var options = ["Intelligence", "Luck", "Strength", "Charisma", "Job Outlook", "Morale"];
        for(var j = 0; j <= 5; j++) {
            var option = document.createElement("option");
            option.value = options[j];
            option.text = option.value;
            element.add(option, j);
        }
        // Append dropdown menu
        document.getElementById("container").appendChild(element);
        
        // Add line break
        document.getElementById("container").appendChild(document.createElement("br"));
        
        // Span text amount
        var span = document.createElement("span");
        span.innerHTML = "Amount: ";
        document.getElementById("container").appendChild(span);
        
        // Create input box
        var element = document.createElement("input");
        element.type = "text";
        element.name = "statAmount" + i;
        var id = "statAmount" + i;
        element.id = id;
        
        //element.addEventListener("click", function(){alert("hello");});
        element.addEventListener("change", function(){ 
            // Ensure stat is between 0 and 100
            var currentValue = document.getElementById(id).value;
            
            if(currentValue > 0 &&  currentValue < 100) {
                document.getElementById(id).style.backgroundColor =  "#40ff15";
                return true;
            } else {
                document.getElementById(id).style.backgroundColor =  "#ff250d";
                return false;
            }

        });

        //console.log("checkStatAmount(this.value, 'statAmount" + i + "')");
        document.getElementById("container").appendChild(element);
        
        if(i >= 1) {
            var element = document.getElementById("addOptionId");
            element.disabled = 'disabled';
        }
    }
    else {
        alert("Can't add more rewards");
        var element = document.getElementById("addOption");
    }


}