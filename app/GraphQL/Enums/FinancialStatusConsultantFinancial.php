<?php

namespace App\GraphQL\Enums;

class FinancialStatusConsultantFinancial 
{
    public const PENDING = 'pending';
    public const APPROVED = 'approved';
    public const SEMI_APPROVED = 'semi_approved';

    public static function getValues(): array
    {
        return [
            self::PENDING,
            self::APPROVED,
            self::SEMI_APPROVED,
        ];
    }
}