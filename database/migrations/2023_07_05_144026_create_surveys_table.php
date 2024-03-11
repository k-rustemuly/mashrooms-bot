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
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('username')->nullable();
            $table->bigInteger('chat_id')->nullable();
            $table->string('name')->nullable();
            $table->string('work')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('location')->nullable();
            $table->string('food')->nullable();
            $table->string('drink')->nullable();
            $table->string('line_up')->nullable();
            $table->string('partner_activations')->nullable();
            $table->string('create_events')->nullable();
            $table->string('role')->nullable();
            $table->string('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surveys');
    }
};
