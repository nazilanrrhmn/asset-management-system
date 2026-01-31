<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:asset_categories,id',
            'location_id' => 'required|exists:locations,id',
            'name'        => 'required|string|max:255',
            'code'        => 'required|string|unique:assets,code,' . ($this->asset?->id),
            'status'      => 'required|in:active,inactive,maintenance,retired',
        ];
    }
}
