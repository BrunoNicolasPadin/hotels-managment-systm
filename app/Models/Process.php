<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Process extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type_id',
        'status_id',
        'user_id',
        'total',
        'file',
        'log',
        'model_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'type_id' => 'integer',
        'status_id' => 'integer',
        'user_id' => 'integer',
        'model_id' => 'integer',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(Lov::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Lov::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function model(): BelongsTo
    {
        return $this->belongsTo(Lov::class);
    }

    public function scopeFilter(Builder $query, array $params): void
    {
        if (isset($params['filter'])) {
            if ($params['filter'] === 'file') {
                $query->where('file', 'LIKE', '%'.trim($params['searchData']).'%');
            } elseif ($params['filter'] === 'log') {
                $query->where('log', 'LIKE', '%'.trim($params['searchData']).'%');
            } elseif ($params['filter'] === 'type') {
                $query->whereHas('type', function ($q) use($params) {
                    $q->where('label', 'LIKE', '%'.trim($params['searchData']).'%');
                });
            } elseif ($params['filter'] === 'status') {
                $query->whereHas('status', function ($q) use($params) {
                    $q->where('label', 'LIKE', '%'.trim($params['searchData']).'%');
                });
            } elseif ($params['filter'] === 'user') {
                $query->whereHas('user', function ($q) use($params) {
                    $q->where('name', 'LIKE', '%'.trim($params['searchData']).'%');
                });
            } elseif ($params['filter'] === 'model') {
                $query->whereHas('model', function ($q) use($params) {
                    $q->where('label', 'LIKE', '%'.trim($params['searchData']).'%');
                });
            } elseif ($params['filter'] === 'id') {
                $query->where('id', $params['searchData']);
            }
        }
    }
}
