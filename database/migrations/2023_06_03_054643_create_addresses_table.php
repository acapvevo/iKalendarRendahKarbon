<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('community_id');
            $table->foreign('community_id')->references('id')->on('communities')->onDelete('cascade');

            $table->unsignedBigInteger('zone_id')->nullable();
            $table->foreign('zone_id')->references('id')->on('zones')->onDelete('cascade');

            $table->char('category', 2)->nullable();

            $table->string('line_1')->nullable();
            $table->string('line_2')->nullable();
            $table->string('line_3')->nullable();
            $table->string('postcode')->nullable();
            $table->string('city')->nullable();
            $table->string('state');
            $table->string('country');

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
        Schema::dropIfExists('addresses');
    }
}
