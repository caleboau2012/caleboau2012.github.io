/**
 * @author Kay Lee
 */
$(document).ready(function(){
	$(".frame").hide();
	$(".slide").show();
	$(".menu_opt").click(function(){
		$(".selected").removeClass("selected");
		$(this).addClass("selected");
		content_show($(this).attr("opt_name"));
	});
});
		
function content_show(type){
	document.getElementById("frame").setAttribute("src", type);
	$(".frame").show();
	$(".slide").hide();
}

function home(){
	$(".selected").removeClass("selected");
	$(this).addClass("selected");
	$(".frame").hide();
	$(".slide").show();
}