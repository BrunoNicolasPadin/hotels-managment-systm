<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hotel extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'photo',
        'description',
        'type_id',
        'address',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'type_id' => 'integer',
        'deleted_at' => 'datetime',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(Lov::class);
    }

    public function scopeFilter(Builder $query, array $params): void
    {
        if (isset($params['filter'])) {
            if ($params['filter'] === 'name') {
                $query->where('name', 'LIKE', '%'.trim($params['searchData']).'%');
            } elseif ($params['filter'] === 'address') {
                $query->where('address', 'LIKE', '%'.trim($params['searchData']).'%');
            } elseif ($params['filter'] === 'type') {
                $query->whereHas('type', function ($q) use($params) {
                    $q->where('label', 'LIKE', '%'.trim($params['searchData']).'%');
                });
            }
        }
    }
}
