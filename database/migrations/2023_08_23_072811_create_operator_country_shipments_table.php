<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperatorCountryShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operator_country_shipments', function (Blueprint $table) {
			$table->id();
			$table->string('shipment_type')->nullable();
			$table->double('receive_amount')->nullable();
			$table->timestamp('shipment_date')->nullable();
			$table->timestamp('delivery_date')->nullable();
			$table->foreignId('sender_branch')->index()->nullable();
			$table->foreignId('receiver_branch')->index()->nullable();
			$table->foreignId('sender_id')->index()->nullable();
			$table->foreignId('receiver_id')->index()->nullable();
			$table->foreignId('from_state_id')->index()->nullable();
			$table->foreignId('from_city_id')->index()->nullable();
			$table->foreignId('from_area_id')->index()->nullable();
			$table->foreignId('to_state_id')->index()->nullable();
			$table->foreignId('to_city_id')->index()->nullable();
			$table->foreignId('to_area_id')->index()->nullable();
			$table->integer('payment_by')->nullable();
			$table->string('payment_type')->nullable();
			$table->integer('payment_status')->nullable();
			$table->string('packing_service')->nullable();
			$table->foreignId('package_id')->index()->nullable();
			$table->foreignId('variant_id')->index()->nullable();
			$table->double('variant_price')->nullable();
			$table->integer('variant_quantity')->nullable();
			$table->double('package_cost')->nullable();
			$table->text('parcel_details')->nullable();
			$table->text('parcel_name')->nullable();
			$table->integer('parcel_quantity')->nullable();
			$table->foreignId('parcel_type_id')->index()->nullable();
			$table->foreignId('parcel_unit_id')->index()->nullable();
			$table->double('cost_per_unit')->nullable();
			$table->double('total_unit')->nullable();
			$table->double('parcel_total_cost')->nullable();
			$table->double('parcel_length')->nullable();
			$table->double('parcel_width')->nullable();
			$table->double('parcel_height')->nullable();
			$table->double('discount')->nullable();
			$table->double('discount_amount')->nullable();
			$table->double('sub_total')->nullable();
			$table->double('pickup_cost')->nullable();
			$table->double('supply_cost')->nullable();
			$table->double('shipping_cost')->nullable();
			$table->double('tax')->nullable();
			$table->double('insurance')->nullable();
			$table->double('total_pay')->nullable();
			$table->boolean('status')->default(1);
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
        Schema::dropIfExists('operator_country_shipments');
    }
}