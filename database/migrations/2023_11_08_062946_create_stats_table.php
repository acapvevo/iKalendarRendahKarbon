<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stats', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('parent_id');
            $table->string('parent_type');

            $table->integer('total_submission')->default(0);
            $table->json('total_submission_each_month')->nullable();
            $table->json('total_submission_each_zone')->nullable();
            $table->json('total_submission_each_type')->nullable();
            $table->json('average_submission_by_month')->nullable();
            $table->json('average_submission_by_zone')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stats');
    }
}
