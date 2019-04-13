<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->decimal('value', 20, 2)->default(0);
            $table->decimal('assumed_value', 20, 2)->default(0);
            $table->string('name');
            $table->unsignedBigInteger('user_id');
            $table->index('user_id');
            $table->timestamps();
        });

        Schema::table('accounts', function($table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
