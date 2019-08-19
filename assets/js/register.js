$(document).ready(function() {

	//On click signup, hide login and show registration form
	$("#signup").click(function() {
		$("#loginPage").slideUp("medium", function(){
			$("#registerPage").slideDown("slow");
		});
	});

	//On click signup, hide registration and show login form
	$("#signin").click(function() {
		$("#registerPage").slideUp("slow", function(){
			$("#loginPage").slideDown("medium");
		});
	});
});