<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'address', 'phone', 'branch_id', 'email', 'password', 'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function scopeSearchByKeyword($query, $keyword)
    {
        if ($keyword!='') {
            $query->where(function ($query) use ($keyword) {
                $query->where("name", "LIKE","%$keyword%")
                    ->orWhere("address", "LIKE", "%$keyword%")
                    ->orWhere("phone", "LIKE", "%$keyword%")
                    ->orWhere("email", "LIKE", "%$keyword%")
                    ->orWhereHas('company', function($query) use($keyword) {
                        $query->where('name', 'LIKE', "%$keyword%");
                    })
                    ->orWhereHas('role', function($query) use($keyword) {
                        $query->where('name', 'LIKE', "%$keyword%");
                    });
            });
        }
        return $query;
    }

    public function role()
    {
        $instance = $this->belongsToMany('Spatie\Permission\Models\Role', 'model_has_roles', 'model_id');
        $instance->getQuery()->select(['id','name']);
        return $instance;
    }

    public function company()
    {
        $instance = $this->hasOne('App\Models\Company', 'id', 'branch_id');
        $instance->getQuery()->select(['id','name']);
        return $instance;
    }

    public function setPasswordAttribute($password)
    {   
        $this->attributes['password'] = bcrypt($password);
    }
}
