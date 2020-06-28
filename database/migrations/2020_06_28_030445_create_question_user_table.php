<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_user', function (Blueprint $table) {
          $table->unsignedBigInteger('question_id');
          $table->unsignedBigInteger('user_id');
          $table->primary(['question_id','user_id']);
          $table->boolean('is_correct')->default(false);
          $table->boolean('is_challenge')->default(false);
          
          // 外部キー制約
          $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('question_user');
    }
}
