/**************************************************
				JAVASCRIPT FUNCTIONS
***************************************************/
//uses prototype
//<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/prototype/1.7.3.0/prototype.js"></script>
//and scriptlicious
//<script src="http://ajax.googleapis.com/ajax/libs/scriptaculous/1.8.2/scriptaculous.js" type="text/javascript"></script>



/*******VALIDATION********/
//Done by Charlie

//validates form using reg exp
function formValidation(){

	//all fields start w/ 
	var blank = "*";

	// if field is empty
	var required = "* This field is required";

	//	NAME
	var name = $("name").value;
	var name_pattern = /^\w{6,16}$/;
	var name_error = "* Invalid input: username must be 6-16 characters";

	// check("name", name, name_pattern, name_error);
	var result = name_pattern.test(name);

	if (result == false) {

		$("name_req").innerHTML = name_error;
		$("name").select();

		return false;

	} else{

		$("name_req").innerHTML = "";
	}

	//	EMAIL
	var email = $("required").innerHTML;
	
	if (email != "") {

		$("email").select();

		return false;
	} 


	//	PASSWORD
	var password = $("pass").value;
	var password_pattern = /^\w{6,16}$/;
	var password_error = "* Invalid input: passwords must be 6-16 characters";

	var result1 = password_pattern.test(password);
	if (result1 == false) {

		$("pass_req").innerHTML = password_error;
		$("pass").select();

		return false;

	} else{

		$("pass_req").innerHTML = "";
	}

	//	VERIFY PASS
	var verify_passwod = $("ver_pass").value;

	if (password != verify_passwod) {

		$("ver_pass_req").innerHTML = "* Password doesnt match";
		$("ver_pass").select();

		return false;

	} else{

		$("ver_pass_req").innerHTML = "";
	}

}


/*******AJAX EMAIL VAL*******/
// Done by Charlie

function email_Av(value){

	new Ajax.Request( "backend/email_check.php", 
	{
		method: "POST",
		parameters: {email: value},
		onSuccess: displayResult
	}
	);
}

function displayResult(ajax){

	$("required").innerHTML =  ajax.responseText;
}



/********DYNAMIC SETTINGS PAGE********/
// Done by Charlie
function setContent(evt, page){

	var content, links;

	content = document.getElementsByClassName("z_tabcontent");
	for (var i = 0; i < content.length; i++) {
		content[i].style.display = "none";
	}

	links = document.getElementsByClassName("z_tab");
	for (var i = 0; i < links.length; i++) {
		links[i].className = links[i].className.replace("active", "");
	}

	document.getElementById(page).style.display = "block";
    evt.currentTarget.className += " active";
}

function allowDelete(){
	document.getElementById("delete_submit").style.visibility = "visible";
}

function changeBG(){

	var newColor = document.getElementById("backColor").value;
	document.body.style.backgroundColor = newColor;

	//stores background color in local storage under bg
	localStorage.setItem("bg", newColor);

}

//
function getBG(){

	var x = localStorage.getItem("bg");

	if (x != ""){
		document.body.style.backgroundColor = x;
	} 
}

/****AJAX FOR WORLD MAP****/
//Done by Charlie and Ryan

//function increment(){
function increment(name, user, spanId){ //used for getting user, span id so function can be reused

	//global vars used for notify()
	note = $(spanId);
	statName = name;

	var amount = $(statName).value;
	var id = $(statName).name;

	//value is hard coded but will come from session vars in BB php
	//var user= 1;

	//AJAX REQUEST
	new Ajax.Request("backend/update_stats.php",{

		method: "POST",
		parameters: {userId:user, statAmount:amount, statId:id},
		onSuccess: notify
		//onFailure: fail

	});
}

/***AJAX response****/

//Done by Charlie
/*
function notify(ajax){

	//scriptlicious
	new Effect.Appear(note, {duration:0.5});

	note.innerHTML = "++ "+statName+" is increased by "+ajax.responseText;

	//scriptlicious
	new Effect.Fade(note, {duration: 2});
}
*/

var ravers;

//notify user of stat increase
//by Ryan
function notify(ajax)
{
	//notification 
	note.innerHTML = "++ "+statName+" is increased by "+ajax.responseText;

	//css change
	ravers = setInterval("raveTitle()",40);
	setTimeout("changeCSS()",999);
}

//set title to random color 
//by Ryan
function raveTitle()
{
	document.getElementById("header").style.color = getRandomColor();
}


//by Ryan
function changeCSS()
{
	note.innerHTML = "";
	clearInterval(ravers);
	document.getElementById("header").style.color = "black";
}



/*********PARTY MODE*******/
//Done by Charlie and Ryan

//sets background to random color
function rave(){

	document.body.style.backgroundColor = getRandomColor();

}

//generates random color
function getRandomColor(){

	var letters = '0123456789ABCDEF';
	var color = '#';

	for (var i = 0; i < 6; i++) {
		color += letters[Math.floor(Math.random() * 16)];
	}

	return color;
}

//alerts user and sets interval and plays audio to engage in party mode
function startParty(){

	var warning = confirm("VOULD YOO LIKE TO PARTY??");

	if(warning){

		setInterval("rave()",40);

		//play audio
		var audio = document.getElementById("audio");
		audio.play();
	}
	
}