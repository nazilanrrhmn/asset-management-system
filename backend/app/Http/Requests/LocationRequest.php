<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $location = $this->route('location');
        $id = is_object($location) ? $location->id : $location;
        return [
            'name' => 'required|string|max:255|unique:locations,name,' . $id,
        ];
    }
}
