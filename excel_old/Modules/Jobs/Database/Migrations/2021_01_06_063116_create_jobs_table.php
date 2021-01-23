<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('excel_job_number');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('store_id');
            $table->date('due_date');
            $table->unsignedBigInteger('assigned_to');
            $table->unsignedBigInteger('priority');
            $table->unsignedBigInteger('status');
            $table->unsignedBigInteger('contractor_id');
            $table->unsignedBigInteger('job_type');
            $table->timestamps();

            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
                ->onDelete('cascade');

            $table->foreign('store_id')
                ->references('id')
                ->on('stores')
                ->onDelete('cascade');

            $table->foreign('assigned_to')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('contractor_id')
                ->references('id')
                ->on('contractors')
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
        Schema::dropIfExists('jobs');
    }
}
