<?php

namespace App\Http\Requests\Costs;

use Illuminate\Foundation\Http\FormRequest;

class CostsCreateRequest extends FormRequest
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
            'side_number' => 'required',
            'category_consumption' => 'required',
            'subcategory_consumption' => 'required',
            'purchase_cost' => 'required',
            'count' => 'required',
            'work_price' => 'required',
            'mileage' => 'required',
            'consumption_title' => 'required',
        ];
    }
}
