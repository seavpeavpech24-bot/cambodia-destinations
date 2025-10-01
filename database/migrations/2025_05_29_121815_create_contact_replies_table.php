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
        Schema::create('contact_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_inquiry_id')->constrained('contact_inquiries')->onDelete('CASCADE');
            $table->string('subject');
            $table->text('content');
            $table->string('file_path', 512)->nullable();
            $table->string('replied_by'); // Assuming this stores a name or identifier, not a foreign key to users
            $table->timestamps(); // This will create created_at and updated_at
            // The SQL had replied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, timestamps() handles created_at and updated_at
            // If you need a separate replied_at with default, you can add it explicitly
            // $table->timestamp('replied_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_replies');
    }
};
