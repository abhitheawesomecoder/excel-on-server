<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contractors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_name');
            $table->string('contact_name');
            $table->string('mobile_tel_no');
            $table->string('main_office_tel_no');
            $table->string('position');
            $table->string('company_address1');
            $table->string('company_address2');
            $table->string('company_city');
            $table->string('company_postcode');
            $table->string('company_email');
            $table->string('company_fax_no');
            $table->string('company_vat_no')->nullable();
            $table->string('billing_address1');
            $table->string('billing_address2');
            $table->string('billing_city');
            $table->string('billing_postcode');
            $table->string('bank_ac_name');
            $table->string('ac_number');
            $table->string('sort_code');
            $table->string('company_reg_no')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contractors');
    }
}
