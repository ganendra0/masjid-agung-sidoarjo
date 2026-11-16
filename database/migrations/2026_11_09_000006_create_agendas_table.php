<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agenda_category_id')->nullable()->constrained('agenda_categories')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('speaker')->nullable();
            $table->longText('description')->nullable();
            $table->string('poster')->nullable();
            $table->string('location')->nullable();
            $table->dateTime('starts_at');
            $table->dateTime('ends_at')->nullable();
            $table->string('status', 20)->default('draft');
            $table->timestamps();

            $table->index(['status', 'starts_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};
