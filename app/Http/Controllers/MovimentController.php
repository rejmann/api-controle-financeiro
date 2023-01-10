<?php

namespace App\Http\Controllers;

use App\DTO\MovimentFilterDTO;
use App\Http\Requests\MovimentStoreRequest;
use App\Http\Requests\MovimentUpdateRequest;
use App\Models\Type;
use App\Services\MovimentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MovimentController extends Controller
{
    public function __construct(
        private readonly MovimentService $movimentService,
    ) {
    }

    public function indexRevenueAction(Request $request): JsonResponse
    {
        $movimentFilterDto = (new MovimentFilterDTO())
            ->setDescription($request->json()->get('description'))
            ->setType(Type::REVENUE);

        $moviments = $this->movimentService->search($movimentFilterDto);

        return empty($moviments)
            ? response()->json('', Response::HTTP_NO_CONTENT)
            : response()->json($moviments, Response::HTTP_OK);
    }

    public function indexExpenseAction(Request $request): JsonResponse
    {
        $movimentFilterDto = (new MovimentFilterDTO())
            ->setDescription($request->json()->get('description'))
            ->setType(Type::EXPENSE);

        $moviments = $this->movimentService->search($movimentFilterDto);

        return empty($moviments)
            ? response()->json('', Response::HTTP_NO_CONTENT)
            : response()->json($moviments, Response::HTTP_OK);
    }

    public function showRevenueAction(int $id): JsonResponse
    {
        $movimentFilterDto = (new MovimentFilterDTO())
            ->setId($id)
            ->setType(Type::REVENUE);

        $moviment = $this->movimentService->search($movimentFilterDto);

        return $moviment
            ? response()->json($moviment, Response::HTTP_OK)
            : response()->json('', Response::HTTP_NO_CONTENT);
    }

    public function showExpenseAction(int $id): JsonResponse
    {
        $movimentFilterDto = (new MovimentFilterDTO())
            ->setId($id)
            ->setType(Type::REVENUE);

        $moviment = $this->movimentService->search($movimentFilterDto);

        return $moviment
            ? response()->json($moviment, Response::HTTP_OK)
            : response()->json('', Response::HTTP_NO_CONTENT);
    }

    public function storeRevenueAction(MovimentStoreRequest $request): JsonResponse
    {
        $validated = $request->validate();

        if (! $validated->isValid()) {
            return response()->json($validated->erros(), Response::HTTP_BAD_REQUEST);
        }

        $movimentFilterDto = (new MovimentFilterDTO())
            ->setDescription($request->json()->get('description'))
            ->setValue($request->json()->get('value'))
            ->setDate($request->json()->get('date'))
            ->setType(Type::REVENUE)
            ->setCategory($request->json()->get('category'));

        $created = $this->movimentService->create($movimentFilterDto);

        return $created
            ? response()->json($created, Response::HTTP_CREATED)
            : response()->json(
                [
                    'error' => 'Movimentação já cadastrada para o mês em vigência'
                ],
                Response::HTTP_BAD_REQUEST
            );
    }

    public function storeExpenseAction(MovimentStoreRequest $request): JsonResponse
    {
        $validated = $request->validate();

        if (! $validated->isValid()) {
            return response()->json($validated->erros(), Response::HTTP_BAD_REQUEST);
        }

        $movimentFilterDto = (new MovimentFilterDTO())
            ->setDescription($request->json()->get('description'))
            ->setValue($request->json()->get('value'))
            ->setDate($request->json()->get('date'))
            ->setType(Type::EXPENSE)
            ->setCategory($request->json()->get('category'));

        $created = $this->movimentService->create($movimentFilterDto);

        return $created
            ? response()->json($created, Response::HTTP_CREATED)
            : response()->json(
                [
                    'error' => 'Movimentação já cadastrada para o mês em vigência'
                ],
                Response::HTTP_BAD_REQUEST
            );
    }

    public function showRevenueByMonth(int $year, int $month): JsonResponse
    {
        $movimentFilterDto = (new MovimentFilterDTO())
            ->setType(Type::REVENUE)
            ->setDate("01/$month/$year");

        $moviments = $this->movimentService->search($movimentFilterDto);

        return $moviments
            ? response()->json($moviments, Response::HTTP_OK)
            : response()->json('', Response::HTTP_NO_CONTENT);
    }

    public function showExpenseByMonth(int $year, int $month): JsonResponse
    {
        $movimentFilterDto = (new MovimentFilterDTO())
            ->setType(Type::EXPENSE)
            ->setDate("01/$month/$year");

        $moviments = $this->movimentService->search($movimentFilterDto);

        return $moviments
            ? response()->json($moviments, Response::HTTP_OK)
            : response()->json('', Response::HTTP_NO_CONTENT);
    }

    public function updateRevenueAction(MovimentUpdateRequest $request, int $id): JsonResponse
    {
        $validated = $request->validate();

        if (! $validated->isValid()) {
            return response()->json($validated->erros(), Response::HTTP_BAD_REQUEST);
        }

        $movimentFilterDto = (new MovimentFilterDTO())
            ->setId($id)
            ->setDescription($request->json()->get('description'))
            ->setValue($request->json()->get('value'))
            ->setDate($request->json()->get('date'))
            ->setType(Type::REVENUE)
            ->setCategory($request->json()->get('category'));

        $updated =  $this->movimentService->update($movimentFilterDto)->toArray();

        return ! $updated
            ? response()->json('', Response::HTTP_NOT_FOUND)
            : response()->json($updated, Response::HTTP_ACCEPTED);
    }

    public function updateExpenseAction(MovimentUpdateRequest $request, int $id): JsonResponse
    {
        $validated = $request->validate();

        if (! $validated->isValid()) {
            return response()->json($validated->erros(), Response::HTTP_BAD_REQUEST);
        }

        $movimentFilterDto = (new MovimentFilterDTO())
            ->setId($id)
            ->setDescription($request->json()->get('description'))
            ->setValue($request->json()->get('value'))
            ->setDate($request->json()->get('date'))
            ->setType(Type::REVENUE)
            ->setCategory($request->json()->get('category'));

        $updated =  $this->movimentService->update($movimentFilterDto)->toArray();

        return ! $updated
            ? response()->json('', Response::HTTP_NOT_FOUND)
            : response()->json($updated, Response::HTTP_ACCEPTED);
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->movimentService->delete($id)
            ? response()->json('', Response::HTTP_OK)
            : response()->json('', Response::HTTP_NOT_FOUND);
    }
}
