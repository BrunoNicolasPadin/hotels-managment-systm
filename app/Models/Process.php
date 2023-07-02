<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Process extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type_id',
        'status_id',
        'user_id',
        'total',
        'file',
        'log',
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
}
