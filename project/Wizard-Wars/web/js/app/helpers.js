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


    return {
        request: ajaxRequest
    }

})();