<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('proxy_results', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->enum('status',['online','offline','pending'])->default('pending');
            $table->index('status');
            $table->integer('responseTime')->nullable();
            $table->integer('proxyId');
            $table->index('proxyId');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proxies_results');
    }
};
