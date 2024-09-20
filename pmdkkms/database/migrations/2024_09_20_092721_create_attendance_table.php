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
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->string('membership_id', 10)->charset('utf8mb4')->collation('utf8mb4_unicode_ci'); // Match charset and collation with membership table
            $table->date('attendance_date');
            $table->enum('attendance_status', ['present', 'absent', 'excused']);
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('membership_id')
                  ->references('membership_id')
                  ->on('membership')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance');
    }
};

