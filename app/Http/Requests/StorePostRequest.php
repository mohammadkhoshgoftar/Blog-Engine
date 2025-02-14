<?php

namespace App\Http\Requests;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'body' => 'required|string|min:10',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'عنوان پست نباید خالی باشد.',
            'title.max' => 'عنوان پست نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',
            'category.required' => 'دسته‌بندی الزامی است.',
            'category.max' => 'دسته‌بندی نمی‌تواند بیشتر از ۱۰۰ کاراکتر باشد.',
            'body.required' => 'محتوای پست نباید خالی باشد.',
            'body.min' => 'محتوای پست باید حداقل ۱۰ کاراکتر داشته باشد.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => 'خطای ولیدیشن رخ داده است.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
