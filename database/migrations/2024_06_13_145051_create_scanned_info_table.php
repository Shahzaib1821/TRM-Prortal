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
        Schema::create('scanned_info', function (Blueprint $table) {
            $table->id();
            $table->string('FileName');
            $table->string('User');
            $table->integer('TotalRows');
            $table->integer('Good');
            $table->integer('Bad');
            $table->dateTime('TimeSpammed');
            $table->text('LastAction')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scanned_info');
    }
};
