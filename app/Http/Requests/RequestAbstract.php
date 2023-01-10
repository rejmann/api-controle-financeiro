<?php

namespace App\Http\Requests;

use App\Services\ValidatorRequestService;
use Illuminate\Http\Request;

abstract class RequestAbstract extends Request
{
    public function __construct(
        private readonly ValidatorRequestService $validatorRequestService
    ) {
        parent::__construct();
    }

    abstract public function rules(): array;

    abstract public function messages(): array;

    public function validate(): ValidatorRequestService
    {
        return $this->validatorRequestService->validate(
            $this->json()->all(),
            $this->rules(),
            $this->messages()
        );
    }
}
