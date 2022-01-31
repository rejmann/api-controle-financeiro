<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Moviment;
use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\SupportController as Support;

class ResumeController extends Controller
{
    /**
     * @param Request $request
     * @param int $year
     * @param int $month
     * @return \Illuminate\Http\JsonResponse
     */
    public function showByMonth(Request $request, int $year, int $month)
    {
        $resume = [
            'receitas' => $this->totalResumeByType('receitas', $year, $month),
            'despesas' => $this->totalResumeByType('despesas', $year, $month),
            'saldo' => $this->getMovimentsByType('receitas', $year, $month) - $this->getMovimentsByType('despesas', $year, $month),
            'gastos' => [],
        ];

        return response()
            ->json($resume, 404);
    }

    public function totalResumeByType(string $nameType, int $year, int $month)
    {
        // Busca tipo a partir o path passado.
        $type = Type::where('name', $nameType)->first();

        // Busca todas as movimentações do mês da data informada, igual a descrição e tipo.
        $moviments = Moviment::all()->whereBetween('date', [
            date('Y-m-01', strtotime("$year-$month")),
            date('Y-m-t', strtotime("$year-$month"))])
            ->where('types_id', $type->id);

        $sum = 0;
        foreach ($moviments as $moviment)
        {
            $sum += $moviment->value;
        }

        return $sum;
    }

    public function getMovimentsByType(string $nameType, int $year, int $month)
    {
        // Busca tipo a partir o path passado.
        $type = Type::where('name', $nameType)->first();

        $moviments = Moviment::where('date', '<=', date('Y-m-t', strtotime("$year-$month")))
            ->where('types_id', $type->id)
            ->get();

        $sum = 0;
        foreach ($moviments as $moviment)
        {
            $sum += $moviment->value;
        }

        return $sum;
    }

    //TODO: Criar método para que cria array com a lista das despesas gastas por categorias, onde o nome á chave/indice e a soma de todos os gastos é o valor da key/indice.
}
