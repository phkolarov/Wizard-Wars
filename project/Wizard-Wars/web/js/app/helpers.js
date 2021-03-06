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

    function startTimer(duration, display, defaultTime) {
        let timer = duration, minutes, seconds;
        let interval = setInterval(function () {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.text(minutes + ":" + seconds);

            if (--timer < 0) {
                if (defaultTime) {
                    timer = defaultTime;
                } else {
                    clearInterval(interval);
                    return false;
                }
            }
        }, 1000);
    }


    function countDownTimer(seconds, clockId, defaultTime = null) {

        jQuery(function ($) {
            var fiveMinutes = seconds,
                display = $('#' + clockId);
            startTimer(fiveMinutes, display, defaultTime);
        });

    }


    return {
        request: ajaxRequest,
        countDownTimer: countDownTimer
    }

})();