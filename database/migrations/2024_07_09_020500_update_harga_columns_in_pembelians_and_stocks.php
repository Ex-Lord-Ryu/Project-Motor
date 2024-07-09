<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('pembelians', function (Blueprint $table) {
        $table->bigInteger('harga')->change();
        $table->bigInteger('diskon')->change();
        $table->bigInteger('total_harga')->change();
    });

    Schema::table('stocks', function (Blueprint $table) {
        $table->bigInteger('harga')->change();
    });
}

public function down()
{
    Schema::table('pembelians', function (Blueprint $table) {
        $table->integer('harga')->change();
        $table->integer('diskon')->change();
        $table->integer('total_harga')->change();
    });

    Schema::table('stocks', function (Blueprint $table) {
        $table->integer('harga')->change();
    });
}

};
