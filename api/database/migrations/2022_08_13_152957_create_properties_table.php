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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('location_id');
            $table->integer('block');
            $table->integer('lot');
            $table->integer('phase');
            $table->string('lot_size')->nullable();
            $table->string('floor_area')->nullable();
            $table->string('model')->nullable();
            $table->string('photo')->nullable();
            $table->text('description')->nullable();
            $table->integer('contract_price');
            $table->integer('default_monthly_amortization');
            $table->string('term');
            $table->text('status'); // available, reserved, ocuppied
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
            
            $table->unique(["location_id", "block", "lot", "phase"]);

            $table->foreign('location_id')
                ->references('id')
                ->on('locations')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
};
