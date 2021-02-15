<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExercisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("user_id")->index();
            $table->text("description")->nullable();
            $table->decimal("cost", 20, 2)->default(0);
            $table->text("title");
            $table->integer("time");
            $table->boolean("isPrivate")->default(false);
            $table->json("inputFields");
            $table->boolean("isActive")->default(true);

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
        Schema::dropIfExists('exercises');
    }
}
