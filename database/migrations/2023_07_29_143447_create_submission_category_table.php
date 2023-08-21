<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmissionCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submission_category', function (Blueprint $table) {
            $table->id();

            $table->char('code', 2);
            $table->string('name');
            $table->string('description');
            $table->string('symbol');
            $table->string('icon');
            $table->boolean('forCompetition');
            $table->boolean('forActivity');

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
        Schema::dropIfExists('submission_category');
    }
}
