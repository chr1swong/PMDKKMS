<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('title'); // Title of the announcement
            $table->text('content'); // Content of the announcement
            $table->timestamps(); // Automatically managed 'created_at' and 'updated_at' fields
            $table->unsignedInteger('account_id'); // Link back to the account table

            $table->foreign('account_id')->references('account_id')->on('account')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('announcements');
    }
};
