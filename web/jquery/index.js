$(".desplegable").hide();

if((screen.width>=992) && (screen.height>=768)){
	$("#usuario").mouseenter(function() {
		$(".desplegable").show();
	}).mouseleave(function() {
		$(".desplegable").hide();
	});
	
	$(".desplegable").mouseenter(function() {
		$(".desplegable").show();
	}).mouseleave(function() {
		$(".desplegable").hide();
	});	
}
else{
	$("#usuario").click(function() {
		$(".desplegable").toggle();
	});
}
	
$('select').select2();

$('.cerrar').click(function(){
	fina=$("audio").length;
    finv=$("video").length;
    if(fina >= 0 ) {
		$('audio').pause();
    }
    if(finv >= 0 ) {
        $('video').pause();
    }
});

