<?php

namespace App\Http\Controllers;

use App\Models\Moviment;
use App\Models\Type;
use Illuminate\Http\Request;

class MovimentController
{
    public function index()
    {
        return Moviment::all();
    }

    public function store(Request $request)
    {
        $type = Type::where('name', $request->type)->first();

        return response()
            ->json(Moviment::created([
                'description' => $request->description,
                'value' => $request->value,
                'date' => $request->date,
                'types_id' => $type->id,
            ]), 201);
    }
}
