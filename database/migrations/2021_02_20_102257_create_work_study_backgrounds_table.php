<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkStudyBackgroundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_study_backgrounds', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("user_id")->index();
            $table->text("organization");
            $table->text("address");
            $table->dateTime("startDate");
            $table->dateTime("endDate")->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_study_backgrounds');
    }
}
