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
        Schema::create('network_sales_managers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('network_id');
            $table->unsignedBigInteger('manager_id');
            $table->timestamps();

            $table->foreign('network_id')
                ->references('id')
                ->on('networks')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('manager_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('sales_manager_agents');
    }
};
