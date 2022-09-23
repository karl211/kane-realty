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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('profile_type');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->string('suffix')->nullable();
            $table->string('gender')->nullable();
            $table->string('tin')->nullable();
            $table->timestamp('date_of_birth')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('religion')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('zip_code')->nullable();
            $table->text('address')->nullable();

            $table->string('spouse_first_name')->nullable();
            $table->string('spouse_last_name')->nullable();
            $table->string('spouse_middle_name')->nullable();
            $table->timestamp('spouse_date_of_birth')->nullable();
            $table->string('spouse_gender')->nullable();
            $table->string('spouse_tin')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
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
        Schema::dropIfExists('profiles');
    }
};
