<?php

namespace App\GraphQL\Enums;

class StudentStatusConsultantFinancial 
{
    public const OK = 'ok';
    public const REFUSED = 'refused';
    public const FIRED = 'fired';
    public const FINANCIAL_PENDING = 'financial_pending';

    public static function getValues(): array
    {
        return [
            self::OK,
            self::REFUSED,
            self::FIRED,
            self::FINANCIAL_PENDING,
        ];
    }
}