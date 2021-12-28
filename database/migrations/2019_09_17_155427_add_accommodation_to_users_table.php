<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAccommodationToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
	    $table->bigInteger('accommodation_id')->unsigned()->nullable();
	    $table->foreign('accommodation_id')->references('id')->on('accommodations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
	    $table->dropColumn('accommodation_id');
	    $table->dropForeign('users_accommodation_id_foreign');
	});
    }
}
