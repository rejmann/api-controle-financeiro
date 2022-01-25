<?php

namespace App\Http\Controllers;

class MovimentController
{
    public function index()
    {
        return [
            'description',
            'value',
            'date',
        ];
    }
}
