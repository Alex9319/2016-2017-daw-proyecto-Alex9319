$(".desplegable").hide();

if((screen.width>=992) && (screen.height>=768)){
	$("#usuario").mouseenter(function() {
		$(".desplegable").show();
	});

	$("#usuario").mouseleave(function() {
		$(".desplegable").hide();
	});
	
	$(".desplegable").mouseenter(function() {
		$(".desplegable").show();
	});

	$(".desplegable").mouseleave(function() {
		$(".desplegable").hide();
	});	
}
else{
	$("#usuario").click(function() {
		$(".desplegable").toggle();
	});
}
	
$('select').select2()({
    theme: "bootstrap"
});
