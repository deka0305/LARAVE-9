<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->integer('qty');
            $table->decimal('harga', 15, 2);
            $table->string('jenis_barang');
            $table->integer('stok');
            $table->timestamp('created_at')->useCurrent();
            // $table->timestamp('updated_at')->useCurrent(); // Uncomment if needed
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
