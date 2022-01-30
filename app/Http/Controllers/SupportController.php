<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupportController extends Controller
{
    /**
     * @param Request $request
     * @return string
     */
    public static function formatPath(Request $request): string
    {
        return substr($request->path(),0, 8);
    }

    /**
     * @param string $requestDate
     * @param string $modelDate
     * @return bool
     */
    public static function compareDate(string $requestDate, string $modelDate): bool
    {
        return date('Y-m', strtotime($requestDate)) === date('Y-m', strtotime($modelDate));
    }

    /**
     * @param string $date
     * @param $moviments
     * @return bool
     */
    public static function validateMoviment(string $date, $moviments): bool
    {
        foreach ($moviments as $moviment) {
            if (self::compareDate($date, $moviment->date)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param Request $request
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateRequiredResources(Request $request)
    {
        $this->validate(
            $request,
            [
            'description' => 'required|string|max:255',
            'value' => 'required',
            'date' => 'required|date'
            ],
            [
                'description.required' => 'O recurso description é obrigatório',
                'description.string' => 'O recurso description esperado deve ser do tipo string',
                'description.max' => 'O recurso description esperado deve conter no máximo 255 caracteres',
                'value.required' => 'O recurso value é obrigatório',
                'date.required' => 'O recurso date é obrigatório',
            ]);
    }
}
