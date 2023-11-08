<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCalculationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calculations', function (Blueprint $table) {
            $table->json('total_carbon_emission_each_month')->nullable();
            $table->json('total_carbon_emission_each_zone')->nullable();
            $table->renameColumn('average_carbon_emission', 'average_carbon_emission_by_month');
            $table->double('average_carbon_emission_by_zone')->default(0);
            $table->json('total_carbon_emission_each_type_each_month')->nullable();
            $table->json('total_carbon_emission_each_type_each_zone')->nullable();

            $table->double('average_carbon_reduction_by_month')->default(0);
            $table->double('average_carbon_reduction_by_zone')->default(0);
            $table->json('total_carbon_reduction_each_month')->nullable();
            $table->json('total_carbon_reduction_each_zone')->nullable();
            $table->json('average_carbon_reduction_each_type_by_month')->nullable();
            $table->json('average_carbon_reduction_each_type_by_zone')->nullable();
            $table->json('total_carbon_reduction_each_type_each_month')->nullable();
            $table->json('total_carbon_reduction_each_type_each_zone')->nullable();

            $table->renameColumn('average_usage_each_type', 'average_usage_each_type_by_month');
            $table->json('average_usage_each_type_by_zone')->nullable();
            $table->json('total_usage_each_type_each_month')->nullable();
            $table->json('total_usage_each_type_each_zone')->nullable();

            $table->json('average_usage_reduction_each_type_by_month')->nullable();
            $table->json('average_usage_reduction_each_type_by_zone')->nullable();
            $table->json('usage_reduction_each_type_each_month')->nullable();
            $table->json('usage_reduction_each_type_each_zone')->nullable();


            $table->renameColumn('average_charge_each_type', 'average_charge_each_type_by_month');
            $table->json('average_charge_each_type_by_zone')->nullable();
            $table->json('total_charge_each_type_each_month')->nullable();
            $table->json('total_charge_each_type_each_zone')->nullable();

            $table->json('average_charge_reduction_each_type_by_month')->nullable();
            $table->json('average_charge_reduction_each_type_by_zone')->nullable();
            $table->json('charge_reduction_each_type_each_month')->nullable();
            $table->json('charge_reduction_each_type_each_zone')->nullable();

            $table->json('total_weight_each_type_each_month')->nullable();
            $table->json('total_weight_each_type_each_zone')->nullable();
            $table->renameColumn('average_weight_each_type', 'average_weight_each_type_by_month');
            $table->json('average_weight_each_type_by_zone')->nullable();

            $table->json('total_value_each_type_each_month')->nullable();
            $table->json('total_value_each_type_each_zone')->nullable();
            $table->renameColumn('average_value_each_type', 'average_value_each_type_by_month');
            $table->json('average_value_each_type_by_zone')->nullable();

            $table->dropColumn([
                'total_usage',
                'total_usage_reduction',
                'total_charge',
                'average_charge',
                'total_charge_reduction',
                'total_weight',
                'average_weight',
                'total_value',
                'average_value',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
