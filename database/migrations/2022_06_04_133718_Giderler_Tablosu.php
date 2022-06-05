<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GiderlerTablosu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('giderler', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tutar')->length(100);
            $table->string('kategori')->length(100);
            $table->text('açıklama');
            $table->timestamp('tarih')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->string('konum')->length(300)->nullable();
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
