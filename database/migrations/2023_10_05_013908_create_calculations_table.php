<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalculationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calculations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('parent_id');
            $table->string('parent_type');

            $table->double('total_carbon_emission')->default(0);
            $table->double('average_carbon_emission')->default(0);
            $table->double('total_carbon_reduction')->default(0);
            $table->json('total_carbon_emission_each_type')->nullable();
            $table->json('average_carbon_emission_each_type')->nullable();
            $table->json('total_carbon_reduction_each_type')->nullable();

            $table->double('total_usage')->default(0);
            $table->double('total_usage_reduction')->default(0);
            $table->json('total_usage_each_type')->nullable();
            $table->json('average_usage_each_type')->nullable();
            $table->json('usage_reduction_each_type')->nullable();

            $table->double('total_charge')->default(0);
            $table->double('average_charge')->default(0);
            $table->double('total_charge_reduction')->default(0);
            $table->json('total_charge_each_type')->nullable();
            $table->json('average_charge_each_type')->nullable();
            $table->json('charge_reduction_each_type')->nullable();

            $table->double('total_weight')->default(0);
            $table->double('average_weight')->default(0);
            $table->json('total_weight_each_type')->nullable();
            $table->json('average_weight_each_type')->nullable();

            $table->double('total_value')->default(0);
            $table->double('average_value')->default(0);
            $table->json('total_value_each_type')->nullable();
            $table->json('average_value_each_type')->nullable();

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
        Schema::dropIfExists('calculations');
    }
}
