<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Moviment;
use App\Models\Type;
use Illuminate\Http\Request;

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
            'gastos' => $this->createArrayCategory($year, $month),
        ];

        return response()
            ->json($resume, 404);
    }

    /**
     * @param string $nameType
     * @param int $year
     * @param int $month
     * @return int|mixed
     */
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

    /**
     * @param string $nameType
     * @param int $year
     * @param int $month
     * @return int
     */
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

    /**
     * @param int $year
     * @param int $month
     * @return int[]|string[]
     */
    public function createArrayCategory(int $year, int $month)
    {
        $date = [];

        // Busca todas categorias
        $categories = Category::all();

        // Atribui o nome da categoria no array date
        foreach($categories as $category){
            array_push($date, $category->name);
        }

        // Retorna um array com suas relações trocadas, ou seja, as keys de array passam a ser os valores e os valores de array passam a ser as keys
        $date = array_flip($date);

        // Atribui o valor zero a todos as keys
        foreach ($date as $key => $value){
            $date[$key] = 0;
        }

        foreach ($date as $key => $value){

            // Busca a categoria especifica a key
            $category = Category::where('name', $key)->first();

            // Busca todas as movimentações que pertence ao id de uma categoria e de um mês informado
            $movimentsByCategory = Moviment::where('categories_id', $category->id)
                ->whereBetween('date', [
                date('Y-m-01', strtotime("$year-$month")),
                date('Y-m-t', strtotime("$year-$month"))])
                ->get();

            // Soma os valores por categoria
            foreach ($movimentsByCategory as $movimentByCategory){
                $date[$key] += $movimentByCategory->value;
            }
        }

        // Faz um unset nas categorias que tem seu valor zerado
        foreach ($date as $key => $value){
            if(!$value){
                unset($date[$key]);
            }
        }

        return $date;
    }
}
