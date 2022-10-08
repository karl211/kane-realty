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
            $table->unsignedBigInteger('user_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name');
            $table->string('suffix')->nullable();
            $table->string('gender');
            $table->string('tin')->nullable();
            $table->date('date_of_birth');
            $table->string('civil_status');
            $table->string('religion');
            $table->string('contact_number');
            $table->string('zip_code');
            $table->text('address');
            $table->text('facebook_url')->nullable();
            $table->text('instagram_url')->nullable();

            $table->string('spouse_first_name')->nullable();
            $table->string('spouse_last_name')->nullable();
            $table->string('spouse_middle_name')->nullable();
            $table->string('spouse_suffix')->nullable();
            $table->string('spouse_gender')->nullable();
            $table->string('spouse_tin')->nullable();
            $table->date('spouse_date_of_birth')->nullable();
            $table->string('spouse_contact_number')->nullable();

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
