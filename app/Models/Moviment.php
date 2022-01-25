<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Moviment extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'description',
        'value',
        'date',
        'types_id',
    ];

    public function type()
    {
        return $this->belongsTo(Type::class)->first();
    }
}
