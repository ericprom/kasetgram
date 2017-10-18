<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'parent_id', 'uri', 'label', 'icon', 'sort'
    ];

    public function parent() {

		return $this->hasOne('App\Models\Menu', 'id', 'parent_id')->orderBy('sort');

	}

	public function children() {

		return $this->hasMany('App\Models\Menu', 'parent_id', 'id')->orderBy('sort');

	}

	public static function tree() {

		$menus = static::with(implode('.', array_fill(0, 100, 'children')))
		->where('parent_id', '=', '0')
		->orderBy('sort')
		->get();
		return $menus;

	}
}
