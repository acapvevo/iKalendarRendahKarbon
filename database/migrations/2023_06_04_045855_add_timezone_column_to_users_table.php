<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimezoneColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('super_admins', 'timezone')) {
            Schema::table('super_admins', function (Blueprint $table) {
                $table->string('timezone')->after('remember_token')->nullable();
            });
        }

        if (!Schema::hasColumn('admins', 'timezone')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->string('timezone')->after('remember_token')->nullable();
            });
        }

        if (!Schema::hasColumn('communities', 'timezone')) {
            Schema::table('communities', function (Blueprint $table) {
                $table->string('timezone')->after('remember_token')->nullable();
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
        Schema::table('super_admins', function (Blueprint $table) {
            $table->dropColumn('timezone');
        });

        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('timezone');
        });

        Schema::table('communities', function (Blueprint $table) {
            $table->dropColumn('timezone');
        });
    }
}
