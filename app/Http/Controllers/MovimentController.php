<?php

namespace App\Http\Controllers;

use App\Models\Moviment;
use App\Models\Type;
use Illuminate\Http\Request;

class MovimentController extends Controller
{
    public function index(Request $request)
    {
        /**
         * Recupera a URI da rota e retira o último caractere
         * Busca o primeiro tipo
         */
        $type = Type::where('name', substr($request->path(),0, -1))
            ->first();

        /**
         * Returna todos as movimentações em formato json do tipo atribuído na URI da rota
         */
        return response()
            ->json(Moviment::all()
                ->where('types_id', $type->id), 200);
    }

    public function store(Request $request)
    {
        /**
         * Recupera a URI da rota e retira o último caractere
         * Busca o primeiro tipo
         */
        $type = Type::where('name', substr($request->path(),0, -1))->first();

        /**
         * Retorna o cadastro em json da movimentação criada
         */
        return response()
            ->json(Moviment::created([
                'description' => $request->description,
                'value' => $request->value,
                'date' => $request->date,
                'types_id' => $type->id,
            ]), 200);
    }

}
