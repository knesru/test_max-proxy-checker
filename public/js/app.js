"use strict";

window.onload = function () {
    let button = document.getElementById('sendForm');
    let textArea = document.getElementById('proxyList');
    let token = document.getElementsByName('_token')[0].value;
    button.onclick = function(e){
        // e.stopPropagation();
        // e.stopImmediatePropagation();
        // ajax({
        //     url: '/check',
        //     '_token': token,
        //     method: 'POST',
        //
        // });
    }
}

function ajax(params) {
    let defaultParams = {
        'method': 'GET',
        'data': {}
    }
    params = {defaultParams, params};
    return new Promise(function (resolve, reject) {
        var req = new XMLHttpRequest();
        req.open(params.method, params.url, true);
        req.onreadystatechange = function () {
            if (req.readyState == 4) {
                if (req.status == 200)
                    resolve(JSON.parse(req.responseText));
                else
                    reject(Error(req.statusText));
            }
        };
        req.onerror = function () {
            reject(Error("network error"));
        };
        req.send(params.data);
    });
};
