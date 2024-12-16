<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;

class BulkUpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'product_ids' => ['required', 'array'],
        ];
    }

    // This modifies the Error message for category_id
    public function attributes()
    {
        return [
            'category_id' => 'Category'
        ];
    }

}
