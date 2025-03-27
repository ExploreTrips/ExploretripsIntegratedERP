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
        Schema::create('plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',100)->unique();
            $table->decimal('price', 15, 2)->nullable()->default(0.0);
            $table->string('duration',100);
            $table->integer('max_users')->default(0);
            $table->integer('max_customers')->default(0);
            $table->integer('max_venders')->default(0);
            $table->integer('max_clients')->default(0);
            $table->float('storage_limit')->default('0.00');
            $table->integer('chatgpt')->default(0);
            $table->integer('crm')->default(0);
            $table->integer('hrm')->default(0);
            $table->integer('account')->default(0);
            $table->integer('project')->default(0);
            $table->integer('pos')->default(0);
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
