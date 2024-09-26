<?php

namespace App\Interfaces;

interface GeoIpInterface
{
    public function get(string $ip): ?array;
}
