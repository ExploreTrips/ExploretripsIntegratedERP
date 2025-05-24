<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('employee_documents', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->unsignedBigInteger('employee_id');
        $table->unsignedBigInteger('document_id');
        $table->string('document_value');
        $table->unsignedBigInteger('created_by')->nullable();
        $table->timestamps();

        // Foreign keys (assuming related tables exist)
        $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
        $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_documents');
    }
};
