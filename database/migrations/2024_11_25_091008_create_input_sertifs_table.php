<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('input_sertifs', function (Blueprint $table) {
            $table->id();
            $table->string('nokontrak');
            $table->string('nama');
            $table->string('acdrop');
            $table->decimal('sahirrp', 18, 0);
            $table->decimal('saldoblok', 18, 0);
            $table->decimal('angsmdl', 18, 0);
            $table->decimal('angsmgn', 18, 0);
            $table->decimal('angsttl', 18, 0);
            $table->string('tgleff', 18, 0);
            $table->decimal('sertiftrn', 18, 0);
            $table->decimal('tfangs', 18, 0);
            $table->decimal('tfnsbh', 18, 0);
            $table->decimal('sahiratm', 18, 0);
            $table->string('rekpend');
            $table->string('bank');
            $table->string('kdaoh');
            $table->string('tgl', 8);
            $table->string('userinput');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('input_sertifs');
    }
};
