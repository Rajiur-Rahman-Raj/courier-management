<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOCSAttatchmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('o_c_s_attatchments', function (Blueprint $table) {
            $table->id();
			$table->foreignId('operator_country_shipment_id')->index()->nullable();
			$table->string('image')->nullable();
			$table->string('driver')->default('local')->nullable();
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
        Schema::dropIfExists('o_c_s_attatchments');
    }
}
