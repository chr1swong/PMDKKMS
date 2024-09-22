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
        Schema::create('coach_archer', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('coach_id'); // Link to coach account ID
            $table->unsignedInteger('archer_id'); // Link to archer account ID
            $table->timestamp('enrolled_at')->nullable(); // Track when the archer was enrolled
            $table->timestamps();
        
            // Foreign keys with cascading delete
            $table->foreign('coach_id')->references('account_id')->on('account')->onDelete('cascade');
            $table->foreign('archer_id')->references('account_id')->on('account')->onDelete('cascade');
        
            // Ensure unique combinations of coach and archer
            $table->unique(['coach_id', 'archer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coach_archer');
    }
};
