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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Others']);
            $table->string('email');
            $table->string('password');
            $table->text('address')->nullable();
            $table->text('bio')->nullable();
            $table->string('facebook_profile_url')->nullable();
            $table->string('you_tube_profile_url')->nullable();
            $table->string('instagram_profile_url')->nullable();
            $table->string('twitter_profile_url')->nullable();
            $table->string('linkedin_profile_url')->nullable();
            $table->string('profile_image')->nullable();
            $table->enum('theme_color', ['light', 'dark'])->default('light');
            $table->enum('status', ['Active', 'Pending', 'Suspended'])->default('Pending');
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
        Schema::dropIfExists('clients');
    }
};
