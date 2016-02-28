// Homework 2: Javascript & jQuery //
// Please complete the following problems. Remember, you are not allowed to change the index.php file. Only this js file.

// Event listeners are pretty much what they sounds like: they listen and react to events. Sometimes called Event Handlers

// Problem 1 jQuery Event Listeners
// Add one event listener that responds to a click of any of the "Free Movie Download" buttons and pops up an alert message to users. Make up your own text for the alert message! Be creative! Surprise us!


var movies = $("#movies-container").children(".movies");
var end = movies.length;
// console.log(end);
// var classname = document.getElementsByClassName("alert download btn");
// for (var i = 0; i < end; i++) {
// 	classname[i].addEventListener('click', function() {
// 		alert("Hello World!");
// 	});
// }



// var classname = $(".alert download btn");
// var sayHello = function() {
//     alert("Hello World!\n");
// };
//$(classname).bind('click', sayHello);
$(document).ready(function() {
	$( ".alert" ).bind('click', function() {
		alert( "Hello World!" );
	});
});


// Problem 2 jQuery CSS
// Even though best practices suggest that you change classes  and style the classes in a separate css file rather than change CSS directly, occasionally it is necessary to edit CSS directly using JavaScript.
// Find the "Border" button on the Control Panel on the page. Add an event handler so that when it is clicked each movie is styled to have a 3px solid yellow border.
var borderButton = document.getElementById("border");
var addBorder = function() {
	var movies = document.getElementsByClassName("movie-poster");
	for (var i = 0; i < movies.length; i++) {
		movies[i].style.border = "3px solid yellow";
	}
}
border.addEventListener('click', addBorder);



// Problem 3 - jQuery Toggle
// Attach an event handler / listener to the 'Toggle' button on the control panel that changes whether the descriptive text (Title, release date, running time) are visible.
var visible = false;
$(document).ready(function(){
    $("#toggle").click(function(){
    	if (!visible) {
        	$("ul").hide();
        	visible = true;
        }
        else {
        	$("ul").show();
        	visible = false;
        }
    });
});



// Problem 4 - Loading new text
// At the bottom of the page, you'll find a "Favorite Quotes" section. Your function should add quotes there.
// On the file system, you'll find a folder called 'partials' that contains partial html files. Use the jQuery load() function to load a random quote when the "Load Quote" button is clicked.
//Each new quote should replace the old one, not an increasingly long list of quotes.
//You'll need to figure out how to make it random
//Hint: look at Math.random and Math.floor
$(document).ready(function() {
	$("#quotes").click(function() {
		var choose = Math.floor(5 * Math.random());
		$(".quotes").load("partials/quotes_partial" + choose + ".html");
	});
});



// Problem 5a - Helper Functions
/* For this problem, you will be writing two helper functions that will help you with the next problem. 
* The first is a function to return the running time
* If you could change index.php you might naturally put the running time in a <span> of its own 
* with a class that would allow you to easily reference it. But you can't do that so you have to work harder to 
* get the running time.
* Inside #movies-container, the elements are indexed 0 - 5 with one for each of the six movies 
* Write a function that accepts the movie index (0 for episode 1, 1 for episode 2 etc)
* as a parameter and returns the running time
*/
function runningTime(i){
	if (i < 0 || i >= end) {
		return 0;
	}
	var movie = $("#movies-container").children(".movies")[i];
	var ul = $(movie).children("ul");
	var a = $(ul).children("li")[2];
	var text = $(a).text();

	var endT = 14;
	for (var i = text.length; i >= 14; i--) {
		if (text.charAt(i) >= '0' && text.charAt(i) <= '9') {
			endT = i;
			break;
		}
	}
	return text.substring(14, endT + 1);
};

// Verify that this function works. Open your browser's console and type in the following:
	// runningTime(1);
// you should get the following result:
	// 142

//Problem 5b
//Write another function that takes a movie index and a string 
//as parameters. It should replace the line containing the movie's 
//current running time with the contents of the string.

function rewrite(i, string){
	if (i < 0 || i >= end) {
		return 0;
	}
	var movie = $("#movies-container").children(".movies")[i];
	var ul = $(movie).children("ul");
	var a = $(ul).children("li")[2];
	$(a).text(string);
}

// Verify that this function works. Type the following into your console:
//     replace(0,"Running Time: 400 minutes");
// You should see that the line: "Running Time: 133 minutes" under the first movie is replaced with "Running Time: 400 minutes"

//Problem 5c
// Test your rewrite function! Use values from the "Test Rewrite" pick list
// and text input to run your function when the user clicks the "Test" button
// If the user forgot to select a movie, give them a reminder instead of 
// running the function
$(document).ready(function() {
	$("#test_rewrite").click(function() {
		var val = $("#rewrite_select").val();
		var str = $("#rewrite_text").val();
		rewrite(val, str);
	});
});




// Problem 6 - Apply Helper Functions
// Use your helper functions to convert the running time format of all the movies from minutes to ___ hours ___minutes.
// Hint: Be sure to check the running time format so your function 
// responds appropriately if the time has already been converted.
var converted = false;
$(document).ready(function() {
	$("#convert").click(function() {
		if (!converted) {
			for (var i = 0; i < end; i++) {
				var time = runningTime(i);
				var hours = Math.floor(time / 60);
				var minutes = time - hours * 60;
				rewrite(i, "Running Time: " + hours + " hours " + minutes + " minutes");
				converted = true;
			}
		}
		else {
			for (var i = 0; i < end; i++) {
				var time = runningTime(i);
				var hoursRight = time.indexOf(" hours");
				var hours = time.substring(0, hoursRight);
				var minutes = time.substring(hoursRight + 7, time.length);
				var totalTime = Number(hours) * 60 + Number(minutes);
				rewrite(i, "Running Time: " + totalTime + " minutes");
				converted = false;
			}
		}
	});
});
	// OPTIONAL BONUS CHALLENGE - add an "else" statement to the 
	// that converts from hours and mintues back to minutes
	// Note: Maximum score on the assigmnent is 100.
	// else { 






	//}
//});

// Problem 7 - Adding Class
// So far we've learned we can bind events to classes and style them with CSS, but now let's do some logic with classes.
// Write a function that can add a class 'old' to the movie posters of movies released before the year 2000 and bind it to
// the addClass button.
$(document).ready(function() {
	$("#addClass").click(function() {
		var movies = $("#movies-container").children(".movies");
		for (var i = 0; i < end; i++) {
			var movie = $(movies)[i];
			var ul = $(movie).children("ul");
			var a = $(ul).children("li")[1];
			var text = $(a).text();
			var yearStr = text.substring(text.length - 4, text.length);
			var year = Number(yearStr);
			if (year < 2000)
				$(movie).addClass("old");
		}
		
	});
});







// Problem 8 - Implement ReplaceAll
// The search functionality is implemented already below for all of the movie details. 
$("#search").bind('keyup', function(){
	// for each of the paragraphs in main text
	$("ul").children().each(function(){
		//retrieve the current HTML
		var currentString = $(this).html();
		//Remove existing highlights
		currentString = replaceAll(currentString, '<span class="matched">',"");
		currentString = replaceAll(currentString, "</span>","");
		// add in new highlights
		currentString = replaceAll(currentString, $("#search").val(), '<span class="matched">$&</span>');
		// replace the current HTML with highlighted HTML
		$(this).html(currentString);
	});
});

/* Replaces all instances of "replace" with "with_this" in the string "txt"
using regular expressions -- SEE BELOW */
function replaceAll(txt, replace, with_this) {
	return txt.replace(new RegExp(replace, 'g'),with_this);
}

  
 // TODO: You must implement the ReplaceAll functionality. 
$("#replace").bind('click', function(){
	//retrieve the current HTML
	$("ul").children().each(function(){
		var currentString = $(this).html();
		var originalStr = $("#original").val();
		var newStr = $("#newtext").val();
		currentString = replaceAll(currentString, originalStr, newStr);
		$(this).html(currentString);
	});
});

// To recieve bonus points on this assignment, see the description of Problem 6
	//Note: Maximum points for the assignment is 100. Bonus does not make it higher.
	
// Don't forget to read the published assignment which includes uploading your file to CMS.

