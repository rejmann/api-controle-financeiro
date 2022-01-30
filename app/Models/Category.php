<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name'
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function moviments()
    {
        return $this->hasMany(Moviment::class);
    }

}
