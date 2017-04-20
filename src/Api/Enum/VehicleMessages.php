<?php
declare(strict_types=1);

namespace Api\Enum;

class VehicleMessages
{
    const MORE_THAN         = 'This field must have %s or less characters';
    const NOT_BLANK         = 'This field cannot be blank';
    const INVALID_TYPE      = 'Invalid vehicle type';
    const INVALID_BRAND     = 'Invalid vehicle brand';
    const INVALID_MODEL     = 'Invalid vehicle model';
    const INVALID_CATEGORY  = 'Invalid vehicle category';
    const INVALID_PLATE     = 'Invalid vehicle plate';
    const SPECIFIC_LEN      = 'This field must have %s characters';
}
