<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Transaction
 * @package App\Models
 * @version February 20, 2019, 2:21 am UTC
 *
 * @property integer user_id
 * @property integer qrcode_owner_id
 * @property integer qrcode_id
 * @property string payment_method
 * @property string message
 * @property float amount
 * @property string status
 */
class Transaction extends Model
{
    use SoftDeletes;

    public $table = 'transactions';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'qrcode_owner_id',
        'qrcode_id',
        'payment_method',
        'message',
        'amount',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'qrcode_owner_id' => 'integer',
        'qrcode_id' => 'integer',
        'payment_method' => 'string',
        'message' => 'string',
        'amount' => 'float',
        'status' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

// Transaction belongs to the Qrcode table. The foreign key belongs inside the Transactions table

    public function qrcode()

    {
        return $this->belongsTo('App\Models\Qrcode','qrcode_id');// specify the foreign key
    }

    public function user()

    {
        return $this->belongsTo('App\Models\User','user_id');
    }


    public function qrcode_owner()

    {
        // What eloquent will be saying is that a User is connected to the transactions table but not using the user_id but the qrcode_owner_id, find that User. I think it works because the qrcodes table where the particular field is , is already joined to the transactions table.
        return $this->belongsTo('App\Models\User','qrcode_owner_id');
    }


}
