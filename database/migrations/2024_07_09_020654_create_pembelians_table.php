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
        Schema::create('pembelians', function (Blueprint $table) {
            $table->id('id_beli'); // id_beli INT64 NOT NULL AUTO_INCREMENT PRIMARY KEY
            $table->string('nama_supplier')->nullable(); // nama_supplier STRING
            $table->string('alamat')->nullable(); // alamat STRING
            $table->string('email')->nullable(); // email STRING
            $table->string('no_telp')->nullable(); // no_telp STRING
            $table->date('tgl_beli')->nullable(); // tgl_beli DATE
            $table->string('nama_barang')->nullable(); // nama_barang STRING
            $table->string('tipe_barang')->nullable(); // tipe_barang STRING
            $table->bigInteger('harga')->nullable(); // harga INT64 or DECIMAL
            $table->bigInteger('diskon')->nullable(); // diskon INT64 or DECIMAL
            $table->bigInteger('quantity')->nullable(); // quantity INT64
            $table->bigInteger('total_harga')->nullable(); // total_harga INT64 or DECIMAL
            $table->timestamps(); // created_at TIMESTAMP, updated_at TIMESTAMP
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelians');
    }
};
