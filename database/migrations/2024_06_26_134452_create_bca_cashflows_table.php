<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBcaCashflowsTable extends Migration
{
    public function up()
    {
        Schema::create('bca_cashflows', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('uraian');
            $table->unsignedBigInteger('bca_cash_type_id');
            $table->decimal('nominal', 15, 2)->default(0);
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('bca_cash_type_id')->references('id')->on('bca_cash_types')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bca_cashflows');
    }
}
