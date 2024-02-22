<?php

namespace App\GraphQL\Enums;

class FinancialRefusedStatusConsultantFinancial 
{
    public const NOTRETURNED = 'not_returned';
    public const RETURNED = 'returned';
    public const NOMONEY = 'noMoney';   

    public static function getValues(): array
    {
        return [
            self::NOTRETURNED,
            self::RETURNED,
            self::NOMONEY,           
        ];
    }
}