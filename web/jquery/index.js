$(document).ready(function() {
    $(".desplegable").hide();

    if ((screen.width >= 992) && (screen.height >= 768)) {
        $("#usuario").mouseenter(function () {
            $(".desplegable").show();
        }).mouseleave(function () {
            $(".desplegable").hide();
        });

        $(".desplegable").mouseenter(function () {
            $(".desplegable").show();
        }).mouseleave(function () {
            $(".desplegable").hide();
        });
        $('select').select2();

        $(window).resize(function () {
            $('select').select2();
        });
    }
    else {
        $("#usuario").click(function () {
            $(".desplegable").toggle();
        });
    }

    $('.cerrar').click(function () {
        fina = $("audio").length;
        finv = $("video").length;
        if (fina >= 0) {
            for (var i = 0; i < fina; i++) {
                $('audio')[i].pause();
            }
        }
        if (finv >= 0) {
            for (var j = 0; j < finv; j++) {
                $('video')[j].pause();
            }
        }
    });
});
