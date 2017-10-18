<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable = [
        'name', 'account_name', 'account_number', 'branch_id'
    ];

    public function scopeSearchByKeyword($query, $keyword)
    {
        if ($keyword!='') {
            $query->where(function ($query) use ($keyword) {
                $query->where("name", "LIKE","%$keyword%")
                    ->orWhere("account_name", "LIKE", "%$keyword%")
                    ->orWhere("account_number", "LIKE", "%$keyword%");
            });
        }
        return $query;
    }
}
