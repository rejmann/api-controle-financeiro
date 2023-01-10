<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Type extends Model
{
    use HasFactory;

    public const REVENUE = 'receitas';
    public const EXPENSE = 'despesas';

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

    public static function isRevenue(string $type): bool
    {
        return Type::REVENUE === $type;
    }

    public static function isExpense(string $type): bool
    {
        return Type::EXPENSE === $type;
    }
}
