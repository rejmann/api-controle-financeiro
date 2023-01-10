<?php

namespace App\Http\Controllers;

use App\DTO\MovimentFilterDTO;
use App\Models\Type;
use App\Services\ResumeService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResumeController extends Controller
{
    public function __construct(
        private readonly ResumeService $resumeService
    ){
    }

    public function index(int $year, int $month): JsonResponse
    {
        $dto = (new MovimentFilterDTO())->setDate("01/$month/$year");

        $revenue = $this->resumeService->resume($dto->setType(Type::REVENUE));
        $expense = $this->resumeService->resume($dto->setType(Type::EXPENSE));

        return response()->json(
            [
                'receitas' => $revenue,
                'despesas' => $expense,
                'saldo' => $revenue - $expense,
                'gastos' => $this->resumeService->resumeSpending($dto),
            ],
            Response::HTTP_OK
        );
    }
}
