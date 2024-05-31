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
        Schema::create('newslots', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->string('user_id');
            $table->string('name');
            $table->string('email');
            $table->longtext('subject');
            $table->unsignedBigInteger('slot_id');
            $table->foreign('slot_id')->references('id')->on('availabilities')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newslots');
    }
};
