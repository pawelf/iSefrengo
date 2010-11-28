$(document).ready(function(autoload) {
var h=$('.sftabs').height();
$('.sftabs ul.menu a').click(function() {
var a=$(this).attr("href");
$('.sftabs').height(h);
$(a).parent().parent().height($(a).children().filter('div').height()*1.1);
	});// end click
});//end function autoload
