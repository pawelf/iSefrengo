$(document).ready(function(autoload) {
$(".sftabs ul.menu a").click(function() {
var a=$(this).attr("href");
$(a).parent().parent().css( "height" , $(a).children().filter('div').height()*1.1);
	});// end click
});//end function autoload
