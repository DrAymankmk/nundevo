<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoyaltyRewardCoupon extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'clinic_id',
        'service_name_ar',
        'service_name_en',
        'details_ar',
        'details_en',
        'discount_type',
        'discount_value',
        'points_required',
        'expires_at',
        'branch_ids',
        'status',
    ];

    protected $casts = [
        'branch_ids' => 'array',
        'expires_at' => 'date',
    ];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function redemptions()
    {
        return $this->hasMany(LoyaltyCouponRedemption::class, 'coupon_id');
    }
}
