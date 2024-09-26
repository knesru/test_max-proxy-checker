<?php

return [
    'url_checks'=>[
        'https://ya.ru',
        'https://google.com',
    ],
    'timeouts'=>[
        'connection'=>5,
        'total'=>10,
    ],
    'protocols'=>[
        CURLPROXY_HTTP,
        CURLPROXY_HTTPS,
        CURLPROXY_SOCKS4,
        CURLPROXY_SOCKS4A,
        CURLPROXY_SOCKS5,
    ],
    'batch_size'=>10
];
