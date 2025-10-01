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
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('traveller_name');
            $table->text('content');
            $table->tinyInteger('rating')->unsigned();
            $table->string('image_url')->nullable();
            $table->foreignId('destination_id')->nullable()->constrained('destinations')->onDelete('SET NULL');
            $table->boolean('is_visible')->default(true);
            $table->string('from_country', 100)->nullable();
            $table->timestamps();
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('SET NULL');
            $table->index('rating');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
