<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mosque_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tagline')->nullable();
            $table->text('description')->nullable();
            $table->longText('history')->nullable();
            $table->text('vision')->nullable();
            $table->longText('mission')->nullable();
            $table->json('facilities')->nullable();
            $table->string('photo')->nullable();
            $table->unsignedSmallInteger('established_year')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mosque_profiles');
    }
};
