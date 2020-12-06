<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('firstname',255)->nullable(false);
            $table->string('lastname',255)->nullable(false);
            $table->string('email',255)->nullable(false)->unique();
            $table->string('phone',14)->nullable(false)->unique();
            $table->string('accounting_code',14)->nullable(false);
            $table->string('subsidiary_code',255)->nullable(false);
            $table->tinyInteger('merchant_account')->nullable(true);
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
