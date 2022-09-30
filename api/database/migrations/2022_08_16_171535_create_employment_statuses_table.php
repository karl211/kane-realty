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
        Schema::create('employment_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buyer_id');
            $table->string('employment');
            $table->string('company_name');
            $table->string('location_of_work');
            $table->string('type_of_work');
            $table->string('date_employed');
            $table->string('profession');
            $table->string('position');
            $table->string('business_name');
            $table->string('business_location');
            $table->string('business_industry');
            $table->string('business_date_establish');
            $table->string('business_type');
            $table->timestamps();

            $table->foreign('buyer_id')
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
        Schema::dropIfExists('employment_statuses');
    }
};
