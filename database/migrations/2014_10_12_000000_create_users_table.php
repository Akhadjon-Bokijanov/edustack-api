<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('lastName');
            $table->string('firstName');
            $table->text('address')->nullable();
            $table->dateTime("dateOfBirth")->nullable();
            $table->string("contactNumber")->nullable();
            $table->string("occupation")->nullable();
            $table->text("organization")->nullable();
            $table->text("description")->nullable();
            $table->integer("verification_code");
            $table->string("auth_key");
            $table->integer("role_id")->default(1);
            $table->string('email')->unique()->index();
            $table->decimal("availableSum", 20, 2)->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
