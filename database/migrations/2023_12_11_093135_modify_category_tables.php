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
            $table->decimal('usage')->change();
            $table->decimal('charge')->change();
            $table->decimal('carbon_emission')->change();
        });

        Schema::table('waters', function (Blueprint $table) {
            $table->decimal('usage')->change();
            $table->decimal('charge')->change();
            $table->decimal('carbon_emission')->change();
        });

        Schema::table('recycles', function (Blueprint $table) {
            $table->decimal('weight')->change();
            $table->decimal('value')->change();
            $table->decimal('carbon_emission')->change();
        });

        Schema::table('used_oil', function (Blueprint $table) {
            $table->decimal('weight')->change();
            $table->decimal('value')->change();
            $table->decimal('carbon_emission')->change();
        });

        Schema::table('fabrics', function (Blueprint $table) {
            $table->decimal('weight')->change();
            $table->decimal('value')->change();
            $table->decimal('carbon_emission')->change();
        });

        Schema::table('electronics', function (Blueprint $table) {
            $table->decimal('weight')->change();
            $table->decimal('value')->change();
            $table->decimal('carbon_emission')->change();
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
