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
            $table->timestamps();
            $table->string('login');
            $table->string('password');
            $table->string('email');
            $table->string('email_verified_at')->default(now());
            $table->rememberToken();
            $table->string('name')->nullable();
            $table->string('age')->nullable();
            $table->integer('role')->nullable();
            $table->integer('name_on_project')->nullable();
            $table->integer('english_lvl')->nullable();
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
