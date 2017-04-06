<?php
declare(strict_types=1);

namespace Api\Validator;

class ValidatorMessages
{
    const INVALID_NAME          = 'Invalid name';
    const INVALID_USERNAME      = 'Invalid username';
    const INVALID_EMAIL         = 'Invalid email';
    const LESS_THAN             = 'This field must have %s or more characters';
    const MORE_THAN             = 'This field must have %s or less characters';
    const NOT_BLANK             = 'This field cannot be blank';
    const INVALID_DATE_TIME     = 'Invalid date time. Format: %s';
    const INVALID_IP_ADDRESS    = 'Invalid IP address';
    const INVALID_TYPE          = 'Invalid type of tire';
    const INVALID_BRAND         = 'Invalid brand of tire';
    const INVALID_DURABILITY    = 'Invalid durability';
    const INVALID_COST          = 'Invalid cost';
    const INVALID_NOTE          = 'Invalid note';
    const INVALID_SITUATION     = 'Invalid situation';
}
