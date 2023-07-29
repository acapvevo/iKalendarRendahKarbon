<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('communities', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->string('identification_number')->unique()->nullable();
            $table->string('phone_number')->unique()->nullable();
            $table->string('image')->nullable();

            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');

            $table->boolean('isVerified')->default(false);

            $table->timestamp('email_verified_at')->nullable();

            $table->rememberToken();
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
        Schema::dropIfExists('communities');
    }
}
