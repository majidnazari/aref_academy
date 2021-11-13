<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Validator;

class FaultCreateRequest extends FormRequest
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
            "description" => ['required','min|3', Rule::unique('faults')] ,
        ];        
    }
    public static function Validation($id=0)
    {          
        return response()->json("hi",201);
        $validated=Validator::make(request()->all(),self::rules());
        if($validated->fails())
            return response()->json($validated->errors(),400);
        else
            {
                $data=Fault::create($data);
                return response()->json($data,201);
                
            }
        return $validated;
    }
}
