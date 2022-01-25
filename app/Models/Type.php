<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    public function moviments()
    {
        return $this->hasMany(Moviment::class);
    }

}
