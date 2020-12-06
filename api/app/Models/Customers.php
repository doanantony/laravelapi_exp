<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    protected $fillable=[
        'firstname',
        'lastname',
        'email',
        'phone',
        'accounting_code',
        'subsidiary_code',
        'merchant_account',
    ];

    protected $visible=[
        'id',
        'firstname',
        'lastname',
        'email',
        'phone',
        'accounting_code',
        'subsidiary_code',
        'created_at',
        'updated_at',
    ];

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        $attributes = parent::toArray();
        return $attributes;

    }

    

}
