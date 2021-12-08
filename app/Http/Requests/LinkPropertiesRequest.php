<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\AgentProperty;

class LinkPropertiesRequest extends FormRequest
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
    public function rules()
    {
        $role = array_keys(AgentProperty::ROLE);

        return [
            'agent_id' => ['required', 'exists:agents,id'],
            'property_id' => ['required', 'array', 'exists:properties,id'],
            'role' => ['required', Rule::in($role)],
        ];
    }
}
