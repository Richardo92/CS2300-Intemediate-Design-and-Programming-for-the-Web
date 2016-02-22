//global variable to remember cart item count between events
// var cartitems;

//Once the HTML document is loaded, run some functions
$(document).ready(function(){
	//Set the moveRow function for all rows so that when the row is clicked, the function runs
	$( ".addToCart" ).click( moveRow );
});

//Moves a row from available to cart or back to available depending on where it was when it was clicked
function moveRow() {
	console.log("The moveRow function is being executed");
	//Determine whether the clicked item is in the cart or available
	//then prepend it to the other. Increment or decrement the cartitems count appropriately
	if ( $( this ).attr( 'value' ) == "Add") {
		$(this).val("Remove");
		var item = $( this ).parent().parent();
		var clone = $(item).clone(true);
		$(clone).children(".un").remove();
		$( "#cartBody" ).prepend(clone);
	} else {
		// $(this).val("Add");
		// var node = $("#cartBody").find("tr");
		// console.log($(node).length);
		// var parent = $(this).parent().parent();
		// for (var i = 0; i < $(node).length; i++) {
		// 	var curr = $(node)[i];
		// 	if ($(curr).find(".id").text() === $(parent).find(".id").text()) {
		// 		$(node)[i].remove();
		// 		break;
		// 	}
		// }
	}
}