<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyRequest extends FormRequest
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
            'type_id'       => ['required', 'exists:property_types,id'],
            'subtype_id'    => ['required', 'exists:property_sub_types,id'],
            'title'         => ['required', 'string', 'max:255'],
            'status'        => ['required', 'in:sale,rent,reserved'],
            'description'   => ['nullable', 'string'],
            'price'         => ['required', 'numeric', 'min:0'],
            'area'          => ['required', 'numeric', 'min:0'],
            'floor'         => ['nullable', 'integer', 'min:0'],
            'rooms_count'   => ['nullable', 'integer', 'min:0'],
            'latitude'      => ['required', 'numeric', 'between:-90,90'],
            'longitude'     => ['required', 'numeric', 'between:-180,180'],
            'has_pool'      => ['boolean'],
            'has_garden'    => ['boolean'],
            'has_elevator'  => ['boolean'],
            'solar_energy'  => ['boolean'],
            'features'      => ['nullable', 'string'],
            'nearby_services' => ['nullable', 'string'],
            'image' => ['image','max:2048','nullable'],
        ];
    }
}
