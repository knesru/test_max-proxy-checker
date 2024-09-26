<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProxyServer extends Model
{
    use HasFactory;

    protected $attributes = [
        'port' => '8080',
    ];

    public function setAddress(string $address): void
    {
        if(mb_strpos($address, ':') === false) {
            throw new \Exception('Invalid address format');
        }
        list($this->ip, $this->port) = explode(':', $address);
    }


    public function results(): HasMany{
        return $this->hasMany(ProxyResult::class);
    }
}
