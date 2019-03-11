<?php

namespace App\Repositories;

use App\Models\Account_history;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class Account_historyRepository
 * @package App\Repositories
 * @version March 11, 2019, 7:36 pm UTC
 *
 * @method Account_history findWithoutFail($id, $columns = ['*'])
 * @method Account_history find($id, $columns = ['*'])
 * @method Account_history first($columns = ['*'])
*/
class Account_historyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'account_id',
        'user_id',
        'message'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Account_history::class;
    }
}
