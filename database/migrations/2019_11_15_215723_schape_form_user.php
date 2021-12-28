<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SchapeFormUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('postregistrations', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->unsignedBigInteger('user_id');
			$table->foreign('user_id')->references('id')->on('users');
			$table->string('share_acco')->nullable();
			$table->string('traveling')->default("");
			$table->mediumText('share_travelplans')->nullable();
			$table->string('emergency_name')->default("");
			$table->string('emergency_phone')->default("");
			$table->string('emergency_country')->default("");
			$table->mediumText('dietprefs')->nullable();
			$table->string('shirtsize')->default("");
			$table->string('iccmelse')->nullable();
			$table->string('iccmelse_lastyear')->nullable();
			$table->string('iccmlocation')->nullable();
			$table->mediumText('knowiccm')->nullable();
			$table->mediumText('experince_itman')->nullable();
			$table->mediumText('expert_itman')->nullable();
			$table->mediumText('learn_itman')->nullable();
			$table->mediumText('tech_impl')->nullable();
			$table->mediumText('new_tech')->nullable();
			$table->mediumText('help_worship')->nullable();
			$table->mediumText('speakers')->nullable();
			$table->mediumText('help_iccm')->nullable();
	   });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('postregistrations');
    }
}
