<?php

namespace App\Http\Requests\Cars;

use Illuminate\Foundation\Http\FormRequest;

class CarsCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return boolval(\Auth::user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'manufacturer' => 'required',
            'registration_number' => 'required',
            'side_number' => 'required',
            'purchase_date' => 'required',
            'mileage' => 'required',
            'release_date' => 'required',
            'condition' => 'required',
            'color' => 'required',
        ];
    }
}
