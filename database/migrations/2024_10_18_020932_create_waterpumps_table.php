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
        Schema::create('waterpumps', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên của trạm bơm  
            $table->string('code'); // Mã của trạm bơm  
            $table->string('location'); // Vị trí của trạm bơm 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waterpumps');
    }
};
