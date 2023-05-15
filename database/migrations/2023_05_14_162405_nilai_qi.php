<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NilaiQi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_qi', function (Blueprint $table) {
            $table->id();

            $table->string('kode_alternatif');
            $table->foreign('kode_alternatif')->references('kode_alternatif')->on('alternatif')->onDelete('cascade');
            $table->decimal('nilai_qi', $precision = 8, $scale = 4)->default('0');
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
        //
    }
}
