<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('commentable_id')->nullable();
            $table->string('commentable_type')->nullable();
            $table->index(['commentable_id', 'commentable_type']);
            $table->string('commented_id')->nullable();
            $table->string('commented_type')->nullable();
            $table->index(['commented_id', 'commented_type']);
            $table->longText('comment');
            $table->boolean('approved')->default(true);
            $table->double('rate', 15, 8)->nullable();
            $table->bigInteger('parent_id')->nullable();
            $table->integer('upvote')->default(0);
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
        Schema::dropIfExists('comments');
    }
}
