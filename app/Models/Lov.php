<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lov extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'code',
        'label',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    function scopeFilter(Builder $query, array $params) : void 
    {
        if (isset($params['filter'])) {
            if ($params['filter'] === 'code') {
                $query->where('code', 'LIKE', '%'.trim($params['searchData']).'%');
            }
            elseif ($params['filter'] === 'type') {
                $query->where('type', 'LIKE', '%'.trim($params['searchData']).'%');
            }
        }
    }
}
