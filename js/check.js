/* Created by Logan Wes */

function validateEventName(inEventName) {
	new Ajax.Request("backend/eventNameAvail.php", 
		{
			method: "post",
			parameters: {eventName: inEventName},
			onSuccess: displayResultEvent,
			onFailure: displayFailureMessageEvent
		}
	);
}

function displayResultEvent(ajax) {
	$("eventNameWarning").innerHTML = ajax.responseText;
}

function displayFailureMessageEvent() {
	alert("Ajax request failed");
}

function checkDate(date, id) {
	var result = Date.parse(date);
	
	// Check is make end date isn't before start date
	if(id == "endDate") {
		var startDate = document.getElementById("startDate").value;
		var startDateRes = Date.parse(startDate);
		var endDateRes = Date.parse(date);
		if(endDateRes < startDateRes) {
			alert("Invalid end date");
			document.getElementById(id).style.backgroundColor =  "#ff250d";
			return false; // Prevent code below from running
		}
		
	}
	
	// Check for valid date
	if(!result.isNaN) {
		document.getElementById(id).style.backgroundColor =  "#40ff15";
		return true;
	} else {
		document.getElementById(id).style.backgroundColor =  "#ff250d";
		return false;
	}
}

function checkTime(time, id) {
	// Matching pattern1 doesn't gurantee match
	var pattern1 = /^[012]?[0-9]:[0-9]{2}[ ]*(am|AM|pm|PM)?$/;
	if(pattern1.test(time)) {
		var result = time.split(":");
		var hour = result[0];
		// Check if valid hour
		if(hour > 24) {
			return false;
		}
		var minute = result[1].substr(0, 2);
		// Check if valid minute
		if(minute > 59) {
			return false;
		}
		
		// Test validation complete
		return true;
	}
	else{
		return false;
	}
}

function isValidTime(time, id) {
	if(checkTime(time, id)) {
		document.getElementById(id).style.backgroundColor =  "#40ff15";
		return true;
	} else {
		document.getElementById(id).style.backgroundColor =  "#ff250d";
		return false;
	}
	
}

function checkCommitment(minute, id) {
	// Ensure time is between 0 minutes and 24 hours
	if(minute > 0 &&  minute < 1440) {
		document.getElementById(id).style.backgroundColor =  "#40ff15";
		return true;
	} else {
		document.getElementById(id).style.backgroundColor =  "#ff250d";
		return false;
	}
}

function checkStatAmount(amount, id) {
	// Ensure stat is between 0 and 100
	if(amount > 0 &&  amount < 100) {
		document.getElementById(id).style.backgroundColor =  "#40ff15";
		return true;
	} else {
		document.getElementById(id).style.backgroundColor =  "#ff250d";
		return false;
	}
}

function changeIcon(location) {
	var locationArray = [];
	locationArray['Library'] = 'Library.gif';
	locationArray['Parking Lot'] = 'Parking_Lot.png';
	locationArray['Counseling'] = 'Counseling.png';
	locationArray['RAC'] = 'RAC.png';
	locationArray['The Commons'] = 'The_Commons.png';
	locationArray['Classroom'] = 'Classroom.png';
	locationArray['Computer Lab'] = 'Computer_Lab.png';
	locationArray['Blackboard'] = 'Blackboard.png';
	
	imageLocation = "image/" + locationArray[location]
	document.getElementById("locationImg").src = imageLocation;
}

function checkForm() {
	var isValid = true;
	// Color of text box if valid
	var validGreen = "rgb(64, 255, 21)";
	
	if(document.getElementById("eventName").value.length == 0 || document.getElementById("eventNameWarning").innerHTML != "(Name Available)" ) {
		isValid = false;
	}
	if(document.getElementById("startDate").style.backgroundColor != validGreen) {
		isValid = false;
	}
	if(document.getElementById("endDate").style.backgroundColor != validGreen) {
		isValid = false;
	}
	if(document.getElementById("startTime").style.backgroundColor != validGreen) {
		isValid = false;
	}
	if(document.getElementById("endTime").style.backgroundColor != validGreen) {
		isValid = false;
	}
	if(document.getElementById("commitMinute").style.backgroundColor != validGreen) {
		isValid = false;
	}
	if(document.getElementById("statAmount0").style.backgroundColor != validGreen) {
		isValid = false;
	}
	var ele = document.getElementById("statAmount1");
	if(ele) {
		if(document.getElementById("statAmount1").style.backgroundColor != validGreen) {
			isValid = false;
		}
	}
	if(!isValid) {
		alert("Please fix invalid fields");
	}
	
	return isValid;
}