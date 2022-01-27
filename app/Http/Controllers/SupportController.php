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
        return substr($request->path(), 0, 7);
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
}
