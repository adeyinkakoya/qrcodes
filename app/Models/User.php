<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class User
 * @package App\Models
 * @version February 20, 2019, 2:20 am UTC
 *
 * @property integer role_id
 * @property string name
 * @property string email
 * @property string|\Carbon\Carbon email_verified_at
 * @property string password
 * @property string remember_token
 */
class User extends Model
{
    use SoftDeletes;

    public $table = 'users';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'role_id',
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'role_id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'password' => 'string',
        'remember_token' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];
    
        // Set the relationship with the transactions table with the user_id foreign key. That is a user can have many transactions.

    public function transaction()

    {
        return $this->hasMany('App\Models\Transaction','user_id');
    }

    // Set the relationship with the qrcodes table with the user_id foreign key.

        public function qrcode()
        {
            return $this->hasMany('App\Models\Qrcode', 'user_id');
        }

     // Set the relationship with the roles table with role_id but this time Role is the parent cos the foreign key is in the users table
    public function role()
    {
        return $this->belongsTo('App\Models\role', 'role_id');
    }
    
}
