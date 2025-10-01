<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Creates the 'best_visiting_times' table to store optimal visiting time information.
     */
    public function up(): void
    {
        Schema::create('best_visiting_times', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->text('content'); // Stores detailed visiting time information
            $table->string('group_by', 100)->nullable()->index(); // Optional grouping field with index for faster queries
            $table->timestamps(); // Created_at and updated_at columns
            $table->softDeletes(); // Soft delete column (deleted_at)

            // Optional: Add foreign key if related to another table (uncomment if needed)
            // $table->foreignId('place_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * Drops the 'best_visiting_times' table.
     */
    public function down(): void
    {
        Schema::dropIfExists('best_visiting_times');
    }
};