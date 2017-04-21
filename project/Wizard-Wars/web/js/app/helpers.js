var ww = ww || {};


ww.helpers = (() => {


    function ajaxRequest(url, method, headers, data, success, error) {

        $.ajax({
            url: url,
            method: method,
            headers: headers,
            data: (data),
            success: success,
            error: function (data) {

                console.log(data);
            }
        })
    }

    function startTimer(duration, display) {
        var timer = duration, minutes, seconds;
        setInterval(function () {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.text(minutes + ":" + seconds);

            if (--timer < 0) {
                timer = duration;
            }
        }, 1000);
    }


    function countDownTimer(seconds,clockId) {

        jQuery(function ($) {
            var fiveMinutes = seconds,
                display = $('#'+clockId);
            startTimer(fiveMinutes, display);
        });

    }


    return {
        request: ajaxRequest,
        countDownTimer:countDownTimer
    }

})();