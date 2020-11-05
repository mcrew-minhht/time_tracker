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
            $table->integer('user_id');
            $table->date('working_date')->nullable();
            $table->date('start_working_day')->nullable();
            $table->time('start_working_time')->nullable();
            $table->date('end_working_day')->nullable();
            $table->time('end_working_time')->nullable();
            $table->integer('created_user')->nullable();
            $table->integer('updated_user')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('is_delete')->nullable();
            $table->float('rest_time')->nullable();
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
