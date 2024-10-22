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
            $table->integer('distance'); // Distance attribute
            $table->date('date');

            // Score entries for 6 sets (each set has 6 scores)
            $table->integer('set1_score1')->default(0);
            $table->integer('set1_score2')->default(0);
            $table->integer('set1_score3')->default(0);
            $table->integer('set1_score4')->default(0);
            $table->integer('set1_score5')->default(0);
            $table->integer('set1_score6')->default(0);
            $table->integer('set1_total')->default(0); // Set 1 total

            $table->integer('set2_score1')->default(0);
            $table->integer('set2_score2')->default(0);
            $table->integer('set2_score3')->default(0);
            $table->integer('set2_score4')->default(0);
            $table->integer('set2_score5')->default(0);
            $table->integer('set2_score6')->default(0);
            $table->integer('set2_total')->default(0); // Set 2 total

            $table->integer('set3_score1')->default(0);
            $table->integer('set3_score2')->default(0);
            $table->integer('set3_score3')->default(0);
            $table->integer('set3_score4')->default(0);
            $table->integer('set3_score5')->default(0);
            $table->integer('set3_score6')->default(0);
            $table->integer('set3_total')->default(0); // Set 3 total

            $table->integer('set4_score1')->default(0);
            $table->integer('set4_score2')->default(0);
            $table->integer('set4_score3')->default(0);
            $table->integer('set4_score4')->default(0);
            $table->integer('set4_score5')->default(0);
            $table->integer('set4_score6')->default(0);
            $table->integer('set4_total')->default(0); // Set 4 total

            $table->integer('set5_score1')->default(0);
            $table->integer('set5_score2')->default(0);
            $table->integer('set5_score3')->default(0);
            $table->integer('set5_score4')->default(0);
            $table->integer('set5_score5')->default(0);
            $table->integer('set5_score6')->default(0);
            $table->integer('set5_total')->default(0); // Set 5 total

            $table->integer('set6_score1')->default(0);
            $table->integer('set6_score2')->default(0);
            $table->integer('set6_score3')->default(0);
            $table->integer('set6_score4')->default(0);
            $table->integer('set6_score5')->default(0);
            $table->integer('set6_score6')->default(0);
            $table->integer('set6_total')->default(0); // Set 6 total

            // Store overall data
            $table->integer('overall_total')->default(0); // Store overall total
            $table->integer('x_count')->default(0); // Store X count
            $table->integer('ten_count')->default(0); // Store 10 count
            $table->integer('x_and_ten_count')->default(0); // Store combined X+10 count

            $table->string('canvas_image')->nullable();
            $table->text('notes')->nullable(); // Optional notes
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
