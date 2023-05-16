<?php

namespace App\Rules;

use App\Models\Group;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Log;

class ManagerRuleToUpdateUser implements Rule
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
    public function __construct($id,$user_type)
    {       
        $this->id=$id;
        $this->user_type=$user_type;
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
        // Log::info("the id is : " .$this->id ."the attribute is: ".$attribute .   "the value is: " . $value . "  and the type is : " . $this->user_type );
       
         return $this->CheckAccessibility($this->id,$value,$this->user_type);
    }
    public function CheckAccessibility($id,$group_id,$user_type)
    {
        $user_id_type=User::where('id',$id)->with('group')->first();// the id given for changing 
         //Log::info("user id type: " .  $user_id_type->group->type . " and id is :" .  $id);
       // return false;
        $group=Group::where('id',$group_id)->first();
        if(!$group){
            $this->err="IS_NOT_VALID_GROUP";
            return false;
        }
        if(in_array($group->type,["admin","financial"]) &&  $user_type=="manager") // manager add -> financial and admin user
        {
            $this->err="USER-CREATE-MANAGER_ILLEGAL_ACCESS";
            return false;
            //return Error::createLocatedError("USER-CREATE-MANAGER_ILLEGAL_ACCESS"); 
        }
        if(in_array($group->type,["manager","acceptor","teacher"]) &&  $user_type=="manager" && in_array($user_id_type->group->type,["manager","acceptor","teacher"]) ){
            return true;
        }
        if(in_array($group->type,["admin","financial","manager","acceptor","consultant","teacher"]) &&  $user_type=="admin") // admin  add -> All users 
        {           
            return true;           
        }
        $this->err="USER-CREATE-REQUEST_IS_NOT_ACCEPTABLE";
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
