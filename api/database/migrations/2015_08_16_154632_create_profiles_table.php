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
            // $table->id();
            // $table->unsignedBigInteger('user_id');
            // $table->string('first_name');
            // $table->string('last_name');
            // $table->string('middle_name');
            // $table->string('suffix')->nullable();
            // $table->string('gender');
            // $table->string('tin')->nullable();
            // $table->date('date_of_birth');
            // $table->string('civil_status');
            // $table->string('religion');
            // $table->string('contact_number');
            // $table->string('zip_code');
            // $table->text('address');
            // $table->string('photo')->nullable();
            // $table->text('facebook_url')->nullable();
            // $table->text('instagram_url')->nullable();
            // $table->timestamp('deleted_at')->nullable();
            // $table->timestamps();


            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->string('suffix')->nullable();
            $table->string('gender')->nullable();
            $table->string('tin')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('religion')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('zip_code')->nullable();
            $table->text('address')->nullable();
            $table->string('photo')->nullable();
            $table->text('facebook_url')->nullable();
            $table->text('instagram_url')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();

            $table->unique(["user_id"]);

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
