$(document).ready(function(autoload) {
$(".sftabs ul.menu a").click(function() {
var a=$(this).attr("href");
$(".sftabs").css( "height" , $(a).children().filter('div').height()*1.15);
	});// end click
});//end function autoload
