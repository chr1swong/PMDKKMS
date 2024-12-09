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
            $table->integer('distance');
            $table->date('date');

            // Changing score fields to string
            $table->string('set1_score1')->default('');
            $table->string('set1_score2')->default('');
            $table->string('set1_score3')->default('');
            $table->string('set1_score4')->default('');
            $table->string('set1_score5')->default('');
            $table->string('set1_score6')->default('');
            $table->integer('set1_total')->default(0);

            $table->string('set2_score1')->default('');
            $table->string('set2_score2')->default('');
            $table->string('set2_score3')->default('');
            $table->string('set2_score4')->default('');
            $table->string('set2_score5')->default('');
            $table->string('set2_score6')->default('');
            $table->integer('set2_total')->default(0);

            $table->string('set3_score1')->default('');
            $table->string('set3_score2')->default('');
            $table->string('set3_score3')->default('');
            $table->string('set3_score4')->default('');
            $table->string('set3_score5')->default('');
            $table->string('set3_score6')->default('');
            $table->integer('set3_total')->default(0);

            $table->string('set4_score1')->default('');
            $table->string('set4_score2')->default('');
            $table->string('set4_score3')->default('');
            $table->string('set4_score4')->default('');
            $table->string('set4_score5')->default('');
            $table->string('set4_score6')->default('');
            $table->integer('set4_total')->default(0);

            $table->string('set5_score1')->default('');
            $table->string('set5_score2')->default('');
            $table->string('set5_score3')->default('');
            $table->string('set5_score4')->default('');
            $table->string('set5_score5')->default('');
            $table->string('set5_score6')->default('');
            $table->integer('set5_total')->default(0);

            $table->string('set6_score1')->default('');
            $table->string('set6_score2')->default('');
            $table->string('set6_score3')->default('');
            $table->string('set6_score4')->default('');
            $table->string('set6_score5')->default('');
            $table->string('set6_score6')->default('');
            $table->integer('set6_total')->default(0);

            $table->integer('overall_total')->default(0);
            $table->integer('x_count')->default(0);
            $table->integer('ten_count')->default(0);
            $table->integer('x_and_ten_count')->default(0);

            $table->string('canvas_image')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

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
