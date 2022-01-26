<?php

namespace App\Http\Controllers;

use App\Models\Moviment;
use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\SupportController as Support;

class MovimentController extends Controller
{
    public function index(Request $request)
    {
        /**
         * Recupera da URI os primeiros 7 caracteres que é referente ao tipo de movimentação
         * Busca o primeiro tipo
         */
        $type = Type::where('name', Support::formatPath($request))->first();

        /**
         * Returna todos as movimentações em formato json do tipo atribuído na URI da rota
         */
        return response()
            ->json(Moviment::all()
                ->where('types_id', $type->id), 200);
    }

    public function store(Request $request, Moviment $moviment)
    {
        /**
         * Recupera da URI os primeiros 7 caracteres que é referente ao tipo de movimentação
         * Busca o primeiro tipo
         */
        $type = Type::where('name', Support::formatPath($request))->first();

        /**
         * Adicionado o id do tipo no request
         */
        $request->merge([
            'types_id' => $type->id,
        ]);

        /**
         * Retorna o cadastro em json da movimentação criada
         */
        return response()->json($moviment->create($request->all(), 200));

    }

    public function show(Request $request, int $id)
    {
        /**
         * Valida se a movimentação existe
         */
        if(is_null(Moviment::find($id))){
            return response('', 404);
        }

        /**
         * Retorna a busca em json da movimentação encontrada
         */
        return response()->json(Moviment::find($id)->first(), 200);
    }

    public function update(Request $request, int $id)
    {
        /**
         * Busca a movimentação por id
         */
        $moviment = Moviment::find($id);

        /**
         * Valida se a movimentação existe
         */
        if(is_null($moviment)){
            return response()->json(['error' => "Recurso não encontrado!"], 404);
        }

        /**
         * Preenche os atributos da Model com os valores passados
         */
        $moviment->fill($request->all());

        /**
         * Salva mudanças
         */
        $moviment->save();

        /**
         * Retorna a movimentação atualizada em json
         */
        return response()->json($moviment, 200);
    }

    public function destroy(int $id)
    {
        if(Moviment::destroy($id) === 0){
            return response()->json(['error' => "Recurso não encontrado!"], 404);
        }
        return response()->json('', 200);
    }

}
