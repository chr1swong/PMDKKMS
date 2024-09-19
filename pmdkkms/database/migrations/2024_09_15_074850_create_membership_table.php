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
    Schema::create('membership', function (Blueprint $table) {
        $table->string('membership_id', 10)->primary(); // Membership ID as primary key
        $table->unsignedInteger('account_id')->unique(); // Link back to the account table
        $table->date('membership_expiry');
        $table->integer('membership_status')->comment('1 - active, 2 - inactive');
        $table->timestamps();

        // Foreign key constraint linking to the account table
        $table->foreign('account_id')->references('account_id')->on('account')->onDelete('cascade');
    });
}

/**
     * Reverse the migrations.
     */
public function down(): void
{
    Schema::dropIfExists('membership');
}
};
