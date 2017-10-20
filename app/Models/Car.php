<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
	protected $fillable = [
        'type_id', 
        'make_id', 
        'model', 
        'year', 
        'license', 
        'province', 
        'capacity', 
        'chassi_number', 
        'engine_number', 
        'engine_size', 
        'weight', 
        'customer_id'
    ];

    public function make()
    {
        $instance = $this->hasOne('App\Models\Make', 'id', 'make_id');
        $instance->getQuery()->where('active','=', '1');
        return $instance;
    }

    public function type()
    {
        $instance = $this->hasOne('App\Models\Type', 'id', 'type_id');
        $instance->getQuery()->where('active','=', '1');
        return $instance;
    }
}
