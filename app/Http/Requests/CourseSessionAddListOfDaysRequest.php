<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class CourseSessionAddListOfDaysRequest extends FormRequest
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
        return [
            'days' => 'required|array|max:7',
            'days.*' => 'required|string|distinct|in:Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday,Friday',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after:from_date',
            'from_time' => 'required|date_format:H:i:s',
            'to_time' => 'required|date_format:H:i:s|after:from_time',
            // 'per_price' => 'required|integer',
            // 'products_id' => [
            //     'required',
            //     'integer',
            //     Rule::exists('products', 'id')->where(function ($query) {
            //         return $query->where('is_deleted', false);
            //     }),
            // ],
            // 'single_purchase' => 'nullable|in:0,1'
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'details'      => $validator->errors(),
            'code'      =>400
        ],400
        ));
    }
}
