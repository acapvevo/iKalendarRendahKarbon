<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsedOilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('used_oil', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('parent_id');
            $table->string('parent_type');

            $table->float('weight');
            $table->float('value');
            $table->float('carbon_emission');

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
        Schema::dropIfExists('used_oil');
    }
}
