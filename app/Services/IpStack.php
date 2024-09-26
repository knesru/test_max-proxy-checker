<?php

namespace App\Services;

use App\Interfaces\GeoIpInterface;
use Illuminate\Support\Facades\Http;

class IpStack implements GeoIpInterface
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('geoip.url');
    }

    public function get($ip): ?array
    {
        // http://api.ip.pn/(ip)
        $response = Http::baseUrl($this->baseUrl)->get($ip);

        return $response->json();
    }
}
