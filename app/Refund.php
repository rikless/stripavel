<?php

namespace App;

use App\Stripe\IsStripeEntity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Refund
 * @package App
 */
class Refund extends Model
{
    use SoftDeletes, IsStripeEntity;

    /**
     * @var array
     */
    protected $fillable = [
        'uuid',
        'amount',
        'created',
        'currency',
        'balance_transaction_id',
        'charge_id',
        'metadata',
        'reason',
        'receipt_number',
        'description'
    ];

    /**
     * @var array
     */
    protected $dates = ['created', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * @var array
     */
    public static $stripeFields = [
        'uuid',
        'amount',
        'created',
        'currency',
        'balance_transaction_id',
        'charge_id',
        'metadata',
        'reason',
        'receipt_number',
        'description'
    ];

    /**
     * @var array
     */
    public static $jsonFields = ['metadata'];

    /**
     * @var array
     */
    public static $fieldsConnection = [
        'uuid' => 'id',
        'balance_transaction_id' => 'balance_transaction',
        'charge_id' => 'charge'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function balanceTransaction()
    {
        return $this->belongsTo('App\BalanceTransaction', 'balance_transaction_id', 'uuid');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function charge()
    {
        return $this->belongsTo('App\Charge', 'charge_id', 'uuid');
    }
}
