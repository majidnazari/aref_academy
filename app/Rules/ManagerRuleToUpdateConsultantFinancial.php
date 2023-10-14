<?php

namespace App\Rules;

use App\Models\Group;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Log;

class ManagerRuleToUpdateConsultantFinancial implements Rule
{
    private $id;
    private $group_id;
    private $user_type;
    private $err;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($user_type)
    {
        //$this->id = $id;
        $this->user_type = $user_type;
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->CheckAccessibility($attribute,$value, $this->user_type);
    }
    public function CheckAccessibility( $attribute,$value, $user_type)
    {
        $field_name=explode('.',$attribute);       
        
        if (!$user_type) {
            $this->err = "IS_NOT_VALID_GROUP";
            return false;
        }
        else if (in_array($user_type, ["admin", "consultant_manager"]) && ($field_name[1]==="manager_status") ) 
        {            
            return true;
        }
        else if (in_array($user_type, ["admin", "financial"]) && ($field_name[1]==="financial_status") ) 
        {            
            return true;
        }
       
        $this->err = "USER-UPDATE-REQUEST_IS_NOT_ACCEPTABLE";
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->err;
    }
}
