<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateLoyaltyPointsSystem extends Migration
{
    public function up()
    {
        Schema::create('loyalty_point_rules', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('name_ar');
            $table->string('name_en');
            $table->integer('points')->default(0);
            $table->unsignedInteger('max_per_day')->nullable();
            $table->unsignedInteger('min_words')->nullable();
            $table->unsignedInteger('expires_after_months')->default(12);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('loyalty_point_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('clinic_id')->nullable();
            $table->unsignedBigInteger('reservation_id')->nullable();
            $table->string('source_type')->nullable();
            $table->unsignedBigInteger('source_id')->nullable();
            $table->string('rule_key')->nullable();
            $table->enum('type', ['earn', 'spend', 'reversal', 'expire', 'adjustment'])->default('earn');
            $table->integer('points');
            $table->string('description_ar')->nullable();
            $table->string('description_en')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('clinic_id')->references('id')->on('clinics')->nullOnDelete();
            $table->foreign('reservation_id')->references('id')->on('reservations')->nullOnDelete();
            $table->index(['user_id', 'status', 'expires_at']);
            $table->index(['source_type', 'source_id']);
        });

        Schema::create('loyalty_reward_coupons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinic_id');
            $table->string('service_name_ar');
            $table->string('service_name_en')->nullable();
            $table->text('details_ar')->nullable();
            $table->text('details_en')->nullable();
            $table->enum('discount_type', ['percentage', 'fixed'])->default('percentage');
            $table->decimal('discount_value', 10, 2)->default(0);
            $table->unsignedInteger('points_required');
            $table->date('expires_at');
            $table->json('branch_ids')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('clinic_id')->references('id')->on('clinics')->cascadeOnDelete();
            $table->index(['clinic_id', 'status', 'expires_at']);
        });

        Schema::create('loyalty_coupon_redemptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('coupon_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('clinic_id');
            $table->string('code', 40)->unique();
            $table->string('otp_code', 10)->nullable();
            $table->unsignedInteger('points_spent');
            $table->enum('status', ['pending', 'otp_sent', 'used', 'cancelled', 'expired'])->default('pending');
            $table->timestamp('otp_expires_at')->nullable();
            $table->timestamp('used_at')->nullable();
            $table->unsignedBigInteger('confirmed_by')->nullable();
            $table->timestamps();

            $table->foreign('coupon_id')->references('id')->on('loyalty_reward_coupons')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('clinic_id')->references('id')->on('clinics')->cascadeOnDelete();
            $table->foreign('confirmed_by')->references('id')->on('clinics')->nullOnDelete();
            $table->index(['clinic_id', 'status']);
        });

        Schema::create('loyalty_share_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('clinic_id')->nullable();
            $table->string('shareable_type')->nullable();
            $table->unsignedBigInteger('shareable_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('clinic_id')->references('id')->on('clinics')->nullOnDelete();
            $table->index(['user_id', 'created_at']);
        });

        Schema::table('clinics', function (Blueprint $table) {
            if (!Schema::hasColumn('clinics', 'points_enabled')) {
                $table->boolean('points_enabled')->default(false)->after('status');
            }
            if (!Schema::hasColumn('clinics', 'points_category')) {
                $table->string('points_category')->nullable()->after('points_enabled');
            }
        });

        DB::table('loyalty_point_rules')->insert([
            [
                'key' => 'welcome',
                'name_ar' => 'هدية الترحيب',
                'name_en' => 'Welcome gift',
                'points' => 50,
                'max_per_day' => null,
                'min_words' => null,
                'expires_after_months' => 12,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'completed_visit',
                'name_ar' => 'إتمام الكشف',
                'name_en' => 'Completed visit',
                'points' => 20,
                'max_per_day' => null,
                'min_words' => null,
                'expires_after_months' => 12,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'clinic_cancel_compensation',
                'name_ar' => 'تعويض إلغاء العيادة',
                'name_en' => 'Clinic cancellation compensation',
                'points' => 5,
                'max_per_day' => null,
                'min_words' => null,
                'expires_after_months' => 12,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'share',
                'name_ar' => 'مشاركة من التطبيق',
                'name_en' => 'In-app share',
                'points' => 5,
                'max_per_day' => 2,
                'min_words' => null,
                'expires_after_months' => 12,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'referral',
                'name_ar' => 'مكافأة دعوة مستخدم',
                'name_en' => 'Referral bonus',
                'points' => 20,
                'max_per_day' => null,
                'min_words' => null,
                'expires_after_months' => 12,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'rating',
                'name_ar' => 'تقييم بعد الزيارة',
                'name_en' => 'Visit rating',
                'points' => 10,
                'max_per_day' => null,
                'min_words' => 20,
                'expires_after_months' => 12,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'electronic_payment',
                'name_ar' => 'الدفع الإلكتروني',
                'name_en' => 'Electronic payment',
                'points' => 10,
                'max_per_day' => null,
                'min_words' => null,
                'expires_after_months' => 12,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down()
    {
        Schema::table('clinics', function (Blueprint $table) {
            if (Schema::hasColumn('clinics', 'points_category')) {
                $table->dropColumn('points_category');
            }
            if (Schema::hasColumn('clinics', 'points_enabled')) {
                $table->dropColumn('points_enabled');
            }
        });

        Schema::dropIfExists('loyalty_share_logs');
        Schema::dropIfExists('loyalty_coupon_redemptions');
        Schema::dropIfExists('loyalty_reward_coupons');
        Schema::dropIfExists('loyalty_point_transactions');
        Schema::dropIfExists('loyalty_point_rules');
    }
}
