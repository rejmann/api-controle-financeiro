<?php

namespace App\Http\Controllers;

use App\Models\Moviment;
use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\SupportController as Support;

class MovimentController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Busca tipo a partir o path passado.
        $type = Type::where('name', Support::formatPath($request))->first();

        if ($request->descricao){

            $moviments = Moviment::where('description', 'like', "%{$request->descricao}%")
                ->where('types_id', $type->id)
                ->get();

            if(empty($moviments->all())){
                return response()
                    ->json('', 204);
            }

            return response()
                ->json($moviments->all());
        }

        // Retorna todos as movimentações em formato json do tipo atribuído na URI da rota
        return response()
            ->json(Moviment::all()
                ->where('types_id', $type->id));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // Validando recursos.
        (new Support())->validateRequiredResources($request);

        // Busca tipo a partir o path passado.
        $type = Type::where('name', Support::formatPath($request))->first();

        // Adiciona o id do tipo no request
        $request->merge([
            'types_id' => $type->id,
        ]);

        // Busca todas as movimentações do mês da data informada, igual a descrição e tipo.
        $moviments = Moviment::all()->whereBetween('date', [
            date('Y-m-01', strtotime($request->date)),
            date('Y-m-t', strtotime($request->date))
        ])
            ->where('description', $request->description)
            ->where('types_id', $type->id);

        // Valida de a movimentação já foi cadastrada para o mês informado.
        if (!empty($moviments->all() && Support::validateMoviment($request->date, $moviments))) {
            return response()
                ->json('', 204);
        }

        // Retorna o cadastro em json da movimentação criada.
        return response()->json(Moviment::create($request->all(), 200));

    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, int $id)
    {
        // Busca tipo a partir o path passado.
        $type = Type::where('name', Support::formatPath($request))->first();

        // Busca a primeira movimentação por id/types_id.
        $data = Moviment::all()
            ->where('id', $id)
            ->where('types_id', $type->id)->first();

        // Valida se a movimentação existe.
        if (!$data) {
            return response()
                ->json('', 404);
        }

        // Retorna a busca em json da movimentação encontrada.
        return response()
            ->json($data, 200);
    }

    /**
     * @param Request $request
     * @param int $year
     * @param int $month
     * @return \Illuminate\Http\JsonResponse
     */
    public function showByMonth(Request $request, int $year, int $month)
    {
        // Busca tipo a partir o path passado.
        $type = Type::where('name', Support::formatPath($request))->first();

        // Busca todas as movimentações do mês da data informada, igual a descrição e tipo.
        $moviments = Moviment::all()->whereBetween('date', [
                date('Y-m-01', strtotime("$year-$month")),
                date('Y-m-t', strtotime("$year-$month"))])
            ->where('types_id', $type->id);

        // Verifica se existe movimentações
        if (empty($moviments->all())){
            // Retorna a movimentação atualizada em json.
            return response()
                ->json('',204);
        }

        // Retorna a movimentação atualizada em json.
        return response()
            ->json($moviments);
    }

    public function update(Request $request, int $id)
    {
        // Validando recursos.
        (new Support())->validateRequiredResources($request);

        // Busca a movimentação por id.
        $moviment = Moviment::find($id);

        // Valida se a movimentação existe.
        if (is_null($moviment)) {
            return response()
                ->json('', 404);
        }

        // Preenche os atributos da Model com os valores passados.
        $moviment->fill($request->all());

        // Salva mudanças.
        $moviment->save();

        // Retorna a movimentação atualizada em json.
        return response()->json($moviment);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        if (!Moviment::destroy($id)) {
            return response()
                ->json('', 404);
        }
        return response()
            ->json('', 204);
    }

}
