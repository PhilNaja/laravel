<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetreTransectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metre_transections', function (Blueprint $table) {
            $table->id();
            $table->integer('metre_id');
            $table->integer('bill_id')->nullable();
            $table->float('price_unit');
            $table->float('amount');
            $table->integer('unit');
            $table->integer('pre_unit');
            $table->string('billingcycle');
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
        Schema::dropIfExists('metre__transections');
    }
}
