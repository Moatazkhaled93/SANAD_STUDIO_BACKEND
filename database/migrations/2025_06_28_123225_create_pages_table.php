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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('section_name'); // hero, corporate_innovation, how_we_work, partner_with_us
            $table->json('data'); // Store all multilingual content as JSON
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique('section_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
