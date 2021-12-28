<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('number');
			$table->bigInteger('group_id')->unsigned()->nullable();
			$table->foreign('group_id')->references('id')->on('groups');
            $table->boolean('paid')->default(false);
            $table->decimal('amount', 8, 2);
            $table->string('currency', 3)->nullable();
			$table->foreign('currency')->references('code')->on('currencies');
            $table->decimal('converted_amount', 8, 2)->nullable();
            $table->string('pdf')->nullable();
            $table->string('mollie_id')->nullable();
            $table->string('mollie_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
