<?php
declare(strict_types=1);

namespace Api\Enum;

class TireMessages
{
    const LESS_THAN                 = 'This field must have %s or more characters';
    const MORE_THAN                 = 'This field must have %s or less characters';
    const NOT_BLANK                 = 'This field cannot be blank';
    const INVALID_BRAND             = 'Invalid tire brand';
    const INVALID_SIZE              = 'Invalid tire size';
    const INVALID_TYPE              = 'Invalid tire type';
    const INVALID_MODEL             = 'Invalid tire model';
    const INVALID_CODE              = 'Invalid tire code';
    const INVALID_DOT               = 'Invalid tire DOT';
    const INVALID_PURCHASE_DATE     = 'Invalid tire purchase date';
    const INVALID_PURCHASE_PRICE    = 'Invalid tire purchase price';
    const SPECIFIC_LEN              = 'This field must have %s characters';
}
