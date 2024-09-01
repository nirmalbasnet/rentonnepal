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
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile')->nullable();
            $table->string('profile_pic')->nullable();
            $table->string('user_type')->default("admin");
            $table->string('status')->default("Active");
            $table->string('address')->nullable();
            $table->string('register_type')->default("web");
            $table->boolean('is_profile_completed')->default(true);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('unique_token')->nullable();
            $table->string('password')->nullable();
            $table->string('slug')->unique();
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
