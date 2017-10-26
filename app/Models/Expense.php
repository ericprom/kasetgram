<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    
	protected $fillable = [
        'withdraw_date',
        'withdrawer',
        'farm_id',
        'detail',
        'amount',
        'payment_id',
        'branch_id',
        'active'
    ];

    public function farm()
    {
        $instance = $this->hasOne('App\Models\Farm', 'id', 'farm_id');
        $instance->getQuery()->where('active','=', '1')->select(['id','name']);
        return $instance;
    }

    public function payment()
    {
        $instance = $this->hasOne('App\Models\Payment', 'id', 'payment_id');
        $instance->getQuery()->where('active','=', '1')->select(['id','name']);
        return $instance;
    }

    public function scopeSearchByKeyword($query, $keyword)
    {
        if ($keyword!='') {
            $query->where(function ($query) use ($keyword) {
                $query->where("withdrawer", "LIKE","%$keyword%")
                    ->orWhere("detail", "LIKE", "%$keyword%")
                    ->orWhere("amount", "LIKE", "%$keyword%")
                    ->orWhereHas('farm', function($query) use($keyword) {
                        $query->where('name', 'LIKE', "%$keyword%");
                    })
                    ->orWhereHas('payment', function($query) use($keyword) {
                        $query->where('name', 'LIKE', "%$keyword%");
                    });
            });
        }
        return $query;
    }

    public function scopeSearchByDate($query, $from, $to, $option = 'withdraw_date')
    {
        $query->where(function ($query) use ($option, $from, $to) {
            $query->whereBetween($option, [$from, $to]);
        });
        return $query;
    }
}
