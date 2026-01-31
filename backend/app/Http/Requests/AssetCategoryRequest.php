<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssetCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $category = $this->route('category');
        $id = is_object($category) ? $category->id : $category;
        return [
            'name' => 'required|string|max:255|unique:asset_categories,name,' . $id,
        ];
    }
}
