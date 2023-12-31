<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCategoryTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('electrics', function (Blueprint $table) {
            $table->decimal('usage', 12)->change();
            $table->decimal('charge', 12)->change();
            $table->decimal('carbon_emission', 12)->change();
        });

        Schema::table('waters', function (Blueprint $table) {
            $table->decimal('usage', 12)->change();
            $table->decimal('charge', 12)->change();
            $table->decimal('carbon_emission', 12)->change();
        });

        Schema::table('recycles', function (Blueprint $table) {
            $table->decimal('weight', 12)->change();
            $table->decimal('value', 12)->change();
            $table->decimal('carbon_emission', 12)->change();
        });

        Schema::table('used_oil', function (Blueprint $table) {
            $table->decimal('weight', 12)->change();
            $table->decimal('value', 12)->change();
            $table->decimal('carbon_emission', 12)->change();
        });

        Schema::table('fabrics', function (Blueprint $table) {
            $table->decimal('weight', 12)->change();
            $table->decimal('value', 12)->change();
            $table->decimal('carbon_emission', 12)->change();
        });

        Schema::table('electronics', function (Blueprint $table) {
            $table->decimal('weight', 12)->change();
            $table->decimal('value', 12)->change();
            $table->decimal('carbon_emission', 12)->change();
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
