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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id')->default(1);
            $table->string('particular');
            $table->date('date');
            $table->string('receipt_no');
            $table->string('image')->nullable();
            $table->float('agents_commission_san_vicente', 8, 2)->nullable();
            $table->float('agents_commission_tiniwisan', 8, 2)->nullable();
            $table->float('salary', 8, 2)->nullable();
            $table->float('office_rental_expense', 8, 2)->nullable();
            $table->float('utility_expense', 8, 2)->nullable();
            $table->float('fuel_gasoline', 8, 2)->nullable();
            $table->float('office_materials', 8, 2)->nullable();
            $table->float('repair_maintenance', 8, 2)->nullable();
            $table->float('representation_expense', 8, 2)->nullable();
            $table->float('transportation', 8, 2)->nullable();
            $table->float('retainers', 8, 2)->nullable();
            $table->float('lot_cancellation', 8, 2)->nullable();
            $table->float('web_system_development', 8, 2)->nullable();
            $table->float('professional_fee', 8, 2)->nullable();
            $table->float('processing_fee', 8, 2)->nullable();
            $table->float('equipment', 8, 2)->nullable();
            $table->float('others', 8, 2)->nullable();
            $table->timestamps();

            $table->foreign('branch_id')
                ->references('id')
                ->on('branches')
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
        Schema::dropIfExists('expenses');
    }
};
