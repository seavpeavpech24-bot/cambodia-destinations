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
        Schema::create('map_coordinators', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->foreignId('destination_id')->nullable()->constrained('destinations')->onDelete('CASCADE');
            $table->text('description')->nullable();
            $table->string('type', 100)->nullable();
            $table->string('icon_class', 100)->nullable();
            $table->string('latitude_and_longitude', 100)->nullable();
            $table->text('map_link')->nullable()->nullable();
            $table->string('coordinator_number', 100)->nullable();
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
        Schema::dropIfExists('map_coordinators');
    }
};
