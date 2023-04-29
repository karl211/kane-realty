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
            $table->unsignedBigInteger('particular_id');
            $table->date('date');
            $table->string('receipt_no');
            $table->float('amount', 8, 2);
            $table->float('agents_commission_san_vicente', 8, 2);
            $table->float('agents_commission_tiniwisan', 8, 2);
            $table->float('salary', 8, 2);
            $table->float('office_rental_expense', 8, 2);
            $table->float('utility_expense', 8, 2);
            $table->float('fuel_gasoline', 8, 2);
            $table->float('office_materials', 8, 2);
            $table->float('repair_maintenance', 8, 2);
            $table->float('representation_expense', 8, 2);
            $table->float('transportation', 8, 2);
            $table->float('retainers', 8, 2);
            $table->float('lot_cancellation', 8, 2);
            $table->float('web_system_development', 8, 2);
            $table->float('others', 8, 2);
            $table->timestamps();

            $table->foreign('particular_id')
                ->references('id')
                ->on('particulars')
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
