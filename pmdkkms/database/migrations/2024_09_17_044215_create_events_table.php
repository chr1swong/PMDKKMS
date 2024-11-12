<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations to create the events table.
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id(); // Event ID
            $table->string('title'); // Event title
            $table->date('event_date'); // Event date
            $table->time('start_time'); // Event start time
            $table->time('end_time'); // Event end time
            $table->string('location'); // Event location
            $table->string('color')->default('#5A67D8');  // Event color, default to purple
            $table->timestamps(); // Timestamps for created_at and updated_at
            $table->unsignedInteger('account_id'); // Link back to the account table

            $table->foreign('account_id')->references('account_id')->on('account')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations to drop the events table.
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
