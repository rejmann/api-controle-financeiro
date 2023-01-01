<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    protected $hidden = [
        'id'
    ];

    public function moviments(): HasMany
    {
        return $this->hasMany(Moviment::class);
    }

}
