<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashFlowsTable extends Migration
{
    public function up()
    {
        Schema::create('cash_flows', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('uraian');
            $table->unsignedBigInteger('cash_type_id');
            $table->decimal('nominal', 15, 2)->default(0);
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('cash_type_id')->references('id')->on('cash_types')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::dropIfExists('cash_flows');
    }
}
