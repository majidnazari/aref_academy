<?php

namespace App\GraphQL\Enums;

class ManagerStatusConsultantFinancial 
{
    public const PENDING = 'pending';
    public const APPROVED = 'approved';
    // public const REJECTED = 'rejected';

    public static function getValues(): array
    {
        return [
            self::PENDING,
            self::APPROVED,
            // self::REJECTED,
        ];
    }
}