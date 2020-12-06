<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Programs extends Model
{
    protected $fillable=[
        'name',
        'origin'
    ];

    protected $visible=[
    	'name',
        'id',
        'origin',
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
