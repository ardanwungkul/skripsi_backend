<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hostings', function (Blueprint $table) {
            $table->id();
            $table->integer('capacity')->nullable();
            $table->date('hosting_date')->nullable();
            $table->integer('total_email')->nullable();
            $table->string('login_url')->nullable();
            $table->string('login_username')->nullable();
            $table->string('login_password')->nullable();
            $table->unsignedBigInteger('domain_id');
            $table->foreign('domain_id')->references('id')->on('domains')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hostings');
    }
};
