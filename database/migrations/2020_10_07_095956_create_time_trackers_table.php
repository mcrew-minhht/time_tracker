<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeTrackersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_trackers', function (Blueprint $table) {
            $table->id();
            $table->string('employee_code')->nullable();
            $table->integer('id_project')->nullable();
            $table->date('working_day')->nullable();
            $table->integer('working_time')->nullable();
            $table->date('date_overtime')->nullable();
            $table->integer('time_overtime')->nullable();
            $table->date('date_off')->nullable();
            $table->integer('time_off')->nullable();
            $table->string('memo')->nullable();
            $table->integer('created_user')->nullable();
            $table->integer('updated_user')->nullable();
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
        Schema::dropIfExists('time_trackers');
    }
}
