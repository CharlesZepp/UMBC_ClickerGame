//by Kurt 

function leader(){
	var pass = document.getElementById("leading").value;
	document.body.style.background = "gold";
	document.body.style.textDecoration = "underline";
	new Ajax.Request('backend/uc5dB.php', {
	method:'get',
	parameters:{type: pass},
	onSuccess: updatePage
	});
}

function updatePage(ajax){
	var output =  ajax.responseText.evalJSON();
	console.log(output);
	for (var i = 0; i < 12; i++){
		if (output[i] == null){
			output[i] = "";
		}
	}
	console.log(output);
	document.getElementById("userLead").innerHTML = (output[10] +" : "+ output[11]);
	document.getElementById("lead1").innerHTML = (output[0] +" : "+ output[1]);
	document.getElementById("lead2").innerHTML = (output[2] +" : "+ output[3]);
	document.getElementById("lead3").innerHTML = (output[4] +" : "+ output[5]);
	document.getElementById("lead4").innerHTML = (output[6] +" : "+ output[7]);
    document.getElementById("lead5").innerHTML = (output[8] +" : "+ output[9]);


}