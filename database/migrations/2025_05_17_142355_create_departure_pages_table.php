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
        Schema::create('departure_pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('tone');
            $table->text('message');
            $table->string('gif')->nullable();
            $table->string('sound')->nullable();
            $table->string('author_name')->nullable();
            $table->string('author_email')->nullable();
            $table->boolean('anonymous')->default(false);
            $table->timestamp('release_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departure_pages');
    }
};
