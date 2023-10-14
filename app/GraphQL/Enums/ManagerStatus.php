<?php

namespace App\GraphQL\Enums;

use PhpParser\Builder\Enum_;

class ManagerStatus extends Enum_
{
    const PENDING = 'pending';
    const APPROVED = 'approved';
    const REJECTED = 'rejected';
}