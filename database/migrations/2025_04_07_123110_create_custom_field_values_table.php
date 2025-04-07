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
        Schema::create('table', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('record_id');
            $table->unsignedBigInteger('field_id');
            $table->string('value')->nullable();
            $table->timestamps();
            $table->unique(
                [
                    'record_id',
                    'field_id',
                ]
            );
            $table->foreign('field_id')->references('id')->on('custom_fields')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table');
    }
};
