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
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('category_id')->nullable()->constrained('destination_categories')->onDelete('SET NULL');
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->text('map_link')->nullable();
            $table->string('best_time_to_visit')->nullable();
            $table->string('entry_fee', 100)->nullable();
            $table->string('cover_url', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
