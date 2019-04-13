<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('account_id_from');
            $table->unsignedBigInteger('account_id_to');
            $table->dateTime('plane_date');
            $table->string('message')->nullable();
            $table->decimal('value', 20, 2);
            $table->dateTime('executing_date')->nullable();
            $table->enum('status', ['planned', 'executing', 'completed']);
            $table->timestamps();

            $table->index('account_id_from');
            $table->index('account_id_to');
        });

        Schema::table('transfers', function($table) {
            $table->foreign('account_id_from')->references('id')->on('accounts');
            $table->foreign('account_id_to')->references('id')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transfers');
    }
}
