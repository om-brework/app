<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('day');
            $table->string('time');
            $table->unsignedBigInteger('date_range_id');
            $table->unsignedBigInteger('programme_id');
            $table->unsignedBigInteger('location_id');
            $table->foreign('date_range_id')->references('id')->on('date_ranges');
            $table->foreign('programme_id')->references('id')->on('programmes');
            $table->foreign('location_id')->references('id')->on('locations');
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
        Schema::dropIfExists('classes');
    }
}
