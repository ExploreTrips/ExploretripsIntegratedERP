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

                Schema::create('employees', function (Blueprint $table) {
                $table->bigIncrements('id');

                // Foreign keys
                $table->unsignedBigInteger('user_id')->nullable();
                $table->unsignedBigInteger('branch_id')->nullable();
                $table->unsignedBigInteger('department_id')->nullable();
                $table->unsignedBigInteger('designation_id')->nullable();

                $table->string('name');
                $table->date('dob');
                $table->string('gender');
                $table->string('phone');
                $table->string('address');
                $table->string('email');
                $table->string('password');

                $table->string('employee_id');
                $table->date('company_doj');
                $table->text('documents');

                // Bank details
                $table->string('account_holder_name')->nullable();
                $table->string('account_number')->nullable();
                $table->string('bank_name')->nullable();
                $table->string('bank_ifsc_code')->nullable();
                $table->string('branch_location')->nullable();
                $table->string('tax_payer_id')->nullable();

                $table->unsignedTinyInteger('salary_type')->nullable();
                $table->integer('salary')->nullable();

                $table->boolean('is_active')->default(1);
                $table->unsignedBigInteger('created_by');
                $table->timestamps();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
                $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
                $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
                $table->foreign('designation_id')->references('id')->on('designations')->onDelete('set null');
                // $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
