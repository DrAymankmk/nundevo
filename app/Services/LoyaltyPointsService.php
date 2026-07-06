<?php

namespace App\Services;

use App\Models\LoyaltyCouponRedemption;
use App\Models\LoyaltyPointRule;
use App\Models\LoyaltyPointTransaction;
use App\Models\LoyaltyRewardCoupon;
use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LoyaltyPointsService
{
    public function balance(int $userId): int
    {
        return (int) LoyaltyPointTransaction::where('user_id', $userId)
            ->where('status', 1)
            ->where(function ($query) {
                $query->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->sum('points');
    }

    public function award(User $user, string $ruleKey, array $meta = []): ?LoyaltyPointTransaction
    {
        $rule = LoyaltyPointRule::where('key', $ruleKey)->where('status', 1)->first();

        if (!$rule || $rule->points <= 0) {
            return null;
        }

        if (!empty($meta['source_type']) && !empty($meta['source_id'])) {
            $exists = LoyaltyPointTransaction::where('user_id', $user->id)
                ->where('source_type', $meta['source_type'])
                ->where('source_id', $meta['source_id'])
                ->where('rule_key', $ruleKey)
                ->exists();

            if ($exists) {
                return null;
            }
        }

        if ($rule->max_per_day) {
            $todayCount = LoyaltyPointTransaction::where('user_id', $user->id)
                ->where('rule_key', $ruleKey)
                ->whereDate('created_at', today())
                ->count();

            if ($todayCount >= $rule->max_per_day) {
                return null;
            }
        }

        return LoyaltyPointTransaction::create([
            'user_id' => $user->id,
            'clinic_id' => $meta['clinic_id'] ?? null,
            'reservation_id' => $meta['reservation_id'] ?? null,
            'source_type' => $meta['source_type'] ?? null,
            'source_id' => $meta['source_id'] ?? null,
            'rule_key' => $ruleKey,
            'type' => 'earn',
            'points' => $rule->points,
            'description_ar' => $meta['description_ar'] ?? $rule->name_ar,
            'description_en' => $meta['description_en'] ?? $rule->name_en,
            'expires_at' => now()->addMonths($rule->expires_after_months),
            'status' => 1,
        ]);
    }

    public function redeem(User $user, LoyaltyRewardCoupon $coupon): LoyaltyCouponRedemption
    {
        if ($coupon->status != 1 || $coupon->expires_at->lt(today())) {
            throw new \RuntimeException('Coupon is not available.');
        }

        if ($this->balance($user->id) < $coupon->points_required) {
            throw new \RuntimeException('Not enough points.');
        }

        return DB::transaction(function () use ($user, $coupon) {
            $redemption = LoyaltyCouponRedemption::create([
                'coupon_id' => $coupon->id,
                'user_id' => $user->id,
                'clinic_id' => $coupon->clinic_id,
                'code' => strtoupper(Str::random(10)),
                'points_spent' => $coupon->points_required,
                'status' => 'pending',
            ]);

            LoyaltyPointTransaction::create([
                'user_id' => $user->id,
                'clinic_id' => $coupon->clinic_id,
                'source_type' => LoyaltyCouponRedemption::class,
                'source_id' => $redemption->id,
                'type' => 'spend',
                'points' => -1 * $coupon->points_required,
                'description_ar' => 'استبدال كوبون نقاط',
                'description_en' => 'Reward coupon redemption',
                'status' => 1,
            ]);

            return $redemption;
        });
    }

    public function generateOtp(LoyaltyCouponRedemption $redemption): LoyaltyCouponRedemption
    {
        $otp = (string) random_int(100000, 999999);
        $redemption->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(10),
            'status' => 'otp_sent',
        ]);

        $redemption->loadMissing('user');
        if ($redemption->user && $redemption->user->phone) {
            try {
                VerificationCode::verificationCode($redemption->user->phone, $otp, 'loyalty_coupon');
            } catch (\Throwable $exception) {
                report($exception);
            }
        }

        return $redemption;
    }
}
