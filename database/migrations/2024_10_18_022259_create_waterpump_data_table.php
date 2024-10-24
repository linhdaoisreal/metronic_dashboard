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
        Schema::create('waterpump_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('water_pump_id')->constrained('waterpumps')->onDelete('cascade'); // Khóa ngoại đến bảng water_pumps  
            $table->float('flow_rate', 8, 2); // Lưu lượng (m³/h)  
            $table->float('pressure', 8, 2); // Áp lực (bar)  
            $table->float('output', 8, 2); // Sản lượng (m³)  
            $table->timestamp('recorded_at'); // Thời gian ghi nhận  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waterpump_data');
    }
};
