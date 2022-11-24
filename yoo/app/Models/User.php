<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
    //sample
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mobile_number',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userInfo()
    {
        return $this->hasOne(UserInfo::class);
    }

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    public function driver()
    {
        return $this->hasOne(Driver::class);
    }

    public function management()
    {
        return $this->hasOne(Management::class);
    }

    public function operator()
    {
        return $this->hasOne(Operator::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function topUps()
    {
        return $this->hasMany(TopUp::class);
    }

    public function walletInfos()
    {
        return $this->hasMany(WalletInfo::class);
    }

    public function operatorPaymentInfo()
    {
        return $this->hasMany(OperatorPaymentInfo::class);
    }

    public function shopInfos()
    {
        return $this->hasMany(ShopInfo::class);
    }
}
