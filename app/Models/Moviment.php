<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Moviment extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'value',
        'date',
        'types_id',
        'categories_id'
    ];

    protected $hidden = [
        'types_id',
        'categories_id'
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class)->first();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class)->first();
    }
}
