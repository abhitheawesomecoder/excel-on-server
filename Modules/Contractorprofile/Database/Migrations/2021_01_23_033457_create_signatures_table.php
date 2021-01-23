<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSignaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signatures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('staffcode')->nullable();
            $table->longText('contractorcode');
            $table->unsignedBigInteger('staff_id')->nullable();
            $table->unsignedBigInteger('contractor_id');
            $table->unsignedBigInteger('job_id');
            $table->timestamps();

            $table->foreign('staff_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('contractor_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('job_id')
                ->references('id')
                ->on('jobs')
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
        Schema::dropIfExists('signatures');
    }
}
