<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
	protected $fillable = [
        'title', 
        'firstname', 
        'lastname', 
        'phone', 
        'tax_id', 
        'nationality', 
        'street', 
        'district', 
        'amphoe', 
        'province', 
        'zipcode', 
        'branch_id'
    ];

    public function car()
    {
        $instance = $this->hasOne('App\Models\Car');
        $instance->getQuery()->with(['make', 'type']);
        return $instance;
    }

    public function scopeSearchByKeyword($query, $keyword)
    {
        if ($keyword!='') {
            $query->where(function ($query) use ($keyword) {
                $query->where("firstname", "LIKE","%$keyword%")
                    ->orWhere("lastname", "LIKE", "%$keyword%")
                    ->orWhere("phone", "LIKE", "%$keyword%")
                    ->orWhere("tax_id", "LIKE", "%$keyword%")
                    ->orWhere("nationality", "LIKE", "%$keyword%")
                    ->orWhere("street", "LIKE", "%$keyword%")
                    ->orWhere("district", "LIKE", "%$keyword%")
                    ->orWhere("amphoe", "LIKE", "%$keyword%")
                    ->orWhere("province", "LIKE", "%$keyword%")
                    ->orWhere("zipcode", "LIKE", "%$keyword%")
                    ->orWhereHas('car', function($query) use($keyword) {
                        $query->where('year', 'LIKE', "%$keyword%")
                            ->orWhere("licenser", "LIKE", "%$keyword%")
                            ->orWhere("province", "LIKE", "%$keyword%")
                            ->orWhere("chassi_number", "LIKE", "%$keyword%")
                            ->orWhere("engine_number", "LIKE", "%$keyword%")
                            ->orWhereHas('make', function($query) use($keyword) {
                                $query->where('name', 'LIKE', "%$keyword%");
                            });;
                    });
            });
        }
        return $query;
    }

}
