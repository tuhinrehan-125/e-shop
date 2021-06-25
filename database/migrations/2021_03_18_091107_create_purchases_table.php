<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('business_location_id');
            $table->foreign('business_location_id')->references('id')->on('business_locations')->onDelete('cascade');

            $table->unsignedBigInteger('contact_id');
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');

            $table->enum('purchase_status', ['received', 'pending', 'ordered', 'draft', 'final'])->nullable();
            $table->date('purchase_date')->nullable();
            $table->string('total_purchase_quantity');
            $table->decimal('subtotal_cost', 20, 2)->nullable();
            $table->decimal('purchase_discount', 20, 2)->nullable();
            $table->decimal('purchase_tax', 20, 2)->nullable();
            $table->decimal('total_cost', 20, 2)->nullable();
            $table->decimal('shipping_charge', 20, 2)->nullable();
            $table->string('shipping_details')->nullable();
            $table->enum('payment_status', ['paid', 'due', 'partial'])->nullable();
            $table->text('note')->nullable();

            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('updated_by');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}
