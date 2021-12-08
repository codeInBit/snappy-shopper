<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Property;

class UpdatePropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        $property = array_keys(Property::TYPE);

        return [
            'name' => ['required', Rule::unique('properties')->ignore($request->route('property'))],
            'price' => ['required', 'numeric', 'min:1'],
            'type' => ['required', Rule::in($property)],
        ];
    }
}
