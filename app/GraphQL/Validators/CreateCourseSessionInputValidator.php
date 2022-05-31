<?php

namespace App\GraphQL\Validators;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Validation\Validator;

final class CreateCourseSessionInputValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            // TODO Add your validation rules 
            'course_id' =>
            [
                    'required',
                    'integer'
            ]   ,      
            'name' =>
            [
                'nullable',
                'min:6'
            ],            
            'start_date' =>
            [
                "required",
                'date',
                'date_format:"Y-m-d"',
                Rule::unique('course_sessions','start_date')
                ->where('deleted_at',null)
                ->where('course_id',$this->arg('course_id'))
                ->ignore($this->arg('id'), 'id')
                  
            ],            
            'start_time' =>[
                "required",
                'date_format:"H:i"'
            ],
            'end_time' =>[
                "required",
                'date_format:"H:i"',
                'after:start_time'
            ]
        
        ];
    }
    public function messages():array
    {
        return [
            'name.min' => 'حداقل کاراکتر مورد نیاز برای نام ۶ کاراکتر می باشد.',           
            'start_date.unique' => "تاریخ و نام کلاس تکراری است",
            'start_date.date_format' => " فرمت تاریخ باید به  چهار رقم سال-دو رقم ماه-دورقم روز  وارد شود . ",
            'start_date.date' => "تاریخ به درستی وارد نشده است. ",
           
            'end_time.date_format' => "لطفا فرمت زمان پایان کلاس را به صورت دو رقم ساعت:دقیقه وارد نمایید",
            'end_time.after' => "زمان اتمام کلاس باید بعد از زمان شروع کلاس باشد",
        ];
    }
}
