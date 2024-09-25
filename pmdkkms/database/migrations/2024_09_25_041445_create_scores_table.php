<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoresTable extends Migration
{
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            $table->string('membership_id'); // Link to membership table
            $table->integer('set');
            $table->string('category');
            $table->integer('distance');
            $table->date('date');
            $table->integer('score1')->default(0);
            $table->integer('score2')->default(0);
            $table->integer('score3')->default(0);
            $table->integer('score4')->default(0);
            $table->integer('score5')->default(0);
            $table->integer('score6')->default(0);
            $table->integer('total')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            // Foreign key constraint linking to membership table
            $table->foreign('membership_id')
                  ->references('membership_id')
                  ->on('membership')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('scores');
    }
}
