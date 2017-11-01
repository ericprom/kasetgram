<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    
	protected $fillable = [
        'plant_date',
        'planter',
        'detail',
        'farm_id',
        'branch_id',
        'active'
    ];

    public function farm()
    {
        $instance = $this->hasOne('App\Models\Farm', 'id', 'farm_id');
        $instance->getQuery()->where('active','=', '1')->select(['id','name']);
        return $instance;
    }

    public function scopeSearchByKeyword($query, $keyword)
    {
        if ($keyword!='') {
            $query->where(function ($query) use ($keyword) {
                $query->where("planter", "LIKE","%$keyword%")
                    ->orWhere("detail", "LIKE", "%$keyword%")
                    ->orWhereHas('farm', function($query) use($keyword) {
                        $query->where('name', 'LIKE', "%$keyword%");
                    });
            });
        }
        return $query;
    }

    public function scopeSearchByDate($query, $from, $to, $option = 'plant_date')
    {
        $query->where(function ($query) use ($option, $from, $to) {
            $query->whereBetween($option, [$from, $to]);
        });
        return $query;
    }
}
