<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;


class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable',
            'phone' => 'required',
            'code' => 'nullable'
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'phone' => $this->cleanPhone($this->input('phone')),
        ]);
    }

    private function cleanPhone($phone): string
    {
        return preg_replace('/[^0-9]/', '', $phone);
    }

}
