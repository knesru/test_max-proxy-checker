<?php

namespace Database\Factories;

use App\Models\ProxyServer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProxyServer>
 */
class ProxyServerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ip' => '',
            'port' => ''
        ];
    }
}
