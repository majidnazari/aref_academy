<?php

namespace App\Rules;

use App\Models\Group;
use Illuminate\Contracts\Validation\Rule;

class ManagerRuleToCreateUser implements Rule
{
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
        $this->user_type = $user_type;
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
        return $this->CheckAccessibility($value, $this->user_type);
    }
    public function CheckAccessibility($group_id, $user_type)
    {

        $group = Group::where('id', $group_id)->first();
        if (!$group) {
            $this->err = "IS_NOT_VALID_GROUP";
            return false;
        }
        if (in_array($group->type, ["admin", "financial"]) &&  $user_type == "manager") // manager add -> financial and admin user
        {
            $this->err = "USER-CREATE-MANAGER_ILLEGAL_ACCESS";
            return false;
        }
        if (in_array($group->type, ["manager", "acceptor", "teacher"]) &&  $user_type == "manager") {
            return true;
        }
        if (in_array($group->type, ["admin", "financial", "manager", "acceptor", "teacher", "consultant", "consultant_manager","consultant_acceptor"]) &&  $user_type == "admin") // admin  add -> All users 
        {
            return true;
        }
        $this->err = "USER-CREATE-REQUEST_IS_NOT_ACCEPTABLE";
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
