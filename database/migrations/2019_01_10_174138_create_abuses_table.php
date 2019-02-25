<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abuses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('creator_user_id');
            $table->unsignedInteger('respondent_user_id');
            $table->unsignedInteger('abuse_type_id');
            $table->unsignedInteger('abuse_status_id')->default(1);
            $table->text('description');
            $table->timestamps();
            $table->foreign('creator_user_id')->references('id')
                ->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('respondent_user_id')->references('id')
                ->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('abuse_type_id')->references('id')
                ->on('abuse_types')->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('abuse_status_id')->references('id')
                ->on('abuse_statuses')->onUpdate('cascade')->onDelete('cascade');

            $table->index('creator_user_id');
            $table->index('respondent_user_id');
            $table->index('abuse_type_id');
            $table->index('abuse_status_id');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('abuses');
    }
}
