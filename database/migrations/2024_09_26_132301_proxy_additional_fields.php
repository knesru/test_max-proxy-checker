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
        Schema::table('proxy_servers', function (Blueprint $table) {
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('realip')->nullable();
        });

        Schema::table('proxy_results', function (Blueprint $table) {
            $table->string('protocol');
            $table->string('url')->nullable();
            $table->string('speed')->nullable();
            $table->string('timeout')->nullable();
            $table->string('user_uuid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
