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
        Schema::create('service_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('user_id')->unsigned();
            $table->string('service');
            $table->string('service_id');
            $table->string('token');
            $table->string('refresh_token')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->unique(['user_id', 'service']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_tokens');
    }
};
