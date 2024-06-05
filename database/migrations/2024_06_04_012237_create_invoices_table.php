<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tamu');
            $table->date('tgl_checkin');
            $table->date('tgl_checkout');
            $table->integer('pax');
            $table->decimal('tagihan', 15, 2); // Adjust as needed
            $table->string('sp');
            $table->string('fo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
