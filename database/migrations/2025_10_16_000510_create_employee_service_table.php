<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_service', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->index();
            $table->unsignedBigInteger('service_id')->index();
            $table->timestamps();
            $table->unique(['employee_id','service_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_service');
    }
};


