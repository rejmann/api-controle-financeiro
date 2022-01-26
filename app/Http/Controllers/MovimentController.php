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
         * Recupera da URI os primeiros 7 caracteres que é referente ao tipo de movimentação
         * Busca o primeiro tipo
         */
        $type = Type::where('name', substr($request->path(),0, 7))->first();

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
         * Recupera da URI os primeiros 7 caracteres que é referente ao tipo de movimentação
         * Busca o primeiro tipo
         */
        $type = Type::where('name', substr($request->path(),0, 7))->first();

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

    public function show(Request $request, int $id)
    {
        /**
         * Recupera da URI os primeiros 7 caracteres que é referente ao tipo de movimentação
         * Busca o primeiro tipo
         */
        $type = Type::where('name', substr($request->path(),0, 7))->first();

        /**
         * Busca a primeira movimentação por id/types_id
         */
        $data = Moviment::all()->where('id', $id)->where('types_id', $type->id)->first();

        /**
         * Valida se a movimentação existe
         */
        if(!$data){
            return response()->json(['no_exist' => 'Não foi encontrado movimentação para este id.']);
        }

        /**
         * Retorna a busca em json da movimentação encontrada
         */
        return response()->json($data, 200);
    }

}
