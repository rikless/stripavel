<?php

namespace App;

use App\Stripe\IsStripeEntity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App
 */
class User extends Authenticatable
{
    use SoftDeletes, IsStripeEntity;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'created',
        'first_name',
        'last_name',
        'ip_address',
        'account_balance',
        'description',
        'discount_obj',
        'metadata',
        'shipping',
        'default_source',
        'name',
        'email',
        'password',
        'currency',
        'delinquent',
        'sources',
        'subscriptions',
        'last_four',
        'year',
        'month',
        'fingerprint',
        'confirmation_code'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array
     */
    protected $dates = ['created_at', 'update_at', 'created'];

    /**
     * @var array
     */
    public static $stripeFields = [
        'uuid',
        'created',
        'account_balance',
        'description',
        'discount_obj',
        'metadata',
        'shipping',
        'default_source',
        'email',
        'currency',
        'delinquent',
        'sources',
        'subscriptions_obj'
    ];

    /**
     * @var array
     */
    public static $jsonFields = ['discount_obj', 'metadata', 'shipping', 'sources', 'subscriptions_obj'];

    /**
     * @var array
     */
    public static $fieldsConnection = [
        'uuid' => 'id',
        'discount_obj' => 'discount',
        'subscriptions_obj' => 'subscriptions'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses()
    {
        return $this->hasMany('App\Address', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany('App\Subscription', 'customer_id', 'uuid');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices()
    {
        return $this->hasMany('App\Invoice', 'customer_id', 'uuid');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoicesItems()
    {
        return $this->hasMany('App\Invoiceitem', 'customer_id', 'uuid');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function charges()
    {
        return $this->hasMany('App\Charge', 'customer_id', 'uuid');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function creditCards()
    {
        return $this->hasMany('App\Card', 'customer_id', 'uuid');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cb()
    {
        return $this->hasOne('App\Card', 'default_source', 'uuid');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function discounts()
    {
        return $this->hasMany('App\Discount', 'customer_id', 'uuid');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function coupons()
    {
        return $this->hasMany('App\Coupon', 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bankAccounts()
    {
        return $this->hasMany('App\Bankccount', 'customer_id', 'uuid');
    }
}
