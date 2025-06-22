<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Others'])->nullable();
            $table->string('position')->nullable();
            $table->string('mobile_number');
            $table->string('email');
            $table->string('password');
            $table->text('address')->nullable();
            $table->string('profile_image')->nullable();
            $table->enum('theme_color', ['light', 'dark'])->default('light');
            $table->enum('status', ['Active', 'Inactive', 'Blocked'])->default('Active');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('users');
    }
};
