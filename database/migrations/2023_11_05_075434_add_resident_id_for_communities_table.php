<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResidentIdForCommunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasColumn('communities', 'resident_id')) {
            Schema::table('communities', function (Blueprint $table) {
                $table->unsignedBigInteger('resident_id')->after('id')->nullable();
                $table->foreign('resident_id')->references('id')->on('residents')->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('communities', function (Blueprint $table) {
            $table->dropColumn('resident_id');
        });
    }
}
