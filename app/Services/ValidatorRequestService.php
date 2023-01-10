<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;

class ValidatorRequestService
{
    private ValidatorContract $validator;

    public function validate(array $data, array $rules, array $messages = []): self
    {
        $this->validator = Validator::make(
            $data,
            $rules,
            $messages
        );

        return $this;
    }

    public function isValid(): bool
    {
        return $this->validator->passes();
    }

    public function erros(): array
    {
        return $this->validator->errors()->all();
    }
}
