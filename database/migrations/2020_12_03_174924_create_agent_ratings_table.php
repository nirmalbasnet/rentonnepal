<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_ratings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("rate");
            $table->text("review")->nullable();
            $table->string("publish")->default("No");
            $table->unsignedBigInteger('agent_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign("user_id")->references("id")->on("users")->onUpdate("cascade")->onDelete("cascade");
            $table->foreign("agent_id")->references("id")->on("users")->onUpdate("cascade")->onDelete("cascade");
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
        Schema::dropIfExists('agent_ratings');
    }
}
