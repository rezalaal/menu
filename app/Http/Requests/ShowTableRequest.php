<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowTableRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'id' => ['required', 'integer', 'exists:tables,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'شناسه میز الزامی است.',
            'id.integer'  => 'شناسه میز باید عددی باشد.',
            'id.exists'   => 'میزی با این شناسه پیدا نشد.',
        ];
    }

    /**
     * پارامترهای Route را وارد داده‌های اعتبارسنجی کن
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('id'),
        ]);
    }
}
