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
            $table->text('uraian');
            $table->decimal('nominal', 15, 2);
            $table->enum('type', ['masuk', 'keluar'])->default('masuk'); // Tambahkan kolom type dengan enum 'masuk' atau 'keluar'
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bca_cashflows');
    }
}
