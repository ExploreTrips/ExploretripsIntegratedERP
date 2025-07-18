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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->integer('plan')->nullable();
            $table->date('plan_expire_date')->nullable();
            $table->string('type', 100)->nullable();
            $table->float('storage_limit')->default('0.00');
            $table->string('avatar')->nullable();
            $table->string('messenger_color')->default('#2180f3');
            $table->string('lang', 100)->nullable();
            $table->integer('default_pipeline')->nullable();
            $table->boolean('active_status')->default(0);
            $table->integer('delete_status')->default(1);
            $table->string('mode', 10)->default('light');
            $table->integer('referral_code')->default(0);
            $table->integer('used_referral_code')->default(0);
            $table->integer('commission_amount')->default(0);
            $table->boolean('dark_mode')->default(0);
            $table->integer('is_active')->default(1);
            $table->datetime('last_login_at')->nullable();
            $table->integer('created_by')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });

        if (Schema::hasColumn('users', 'referral_code')){
            $users = DB::table('users')->where('type', 'company')->get();
            foreach($users as $user)
            {
                do {
                    $code = rand(100000, 999999);
                } while (DB::table('users')->where('referral_code', $code)->exists());
                DB::table('users')->where('type','company')->where('id' , $user->id)->update(['referral_code' => $code]);
            }
        }

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
