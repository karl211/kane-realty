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
            $table->string('employment')->nullable();
            $table->string('company_name')->nullable();
            $table->string('location_of_work')->nullable();
            $table->string('type_of_work')->nullable();
            $table->string('date_employed')->nullable();
            $table->string('profession')->nullable();
            $table->string('position')->nullable();
            $table->string('business_name')->nullable();
            $table->string('business_location')->nullable();
            $table->string('business_industry')->nullable();
            $table->string('business_date_establish')->nullable();
            $table->string('business_type')->nullable();
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
