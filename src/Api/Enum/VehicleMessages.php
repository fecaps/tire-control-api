<?php
declare(strict_types=1);

namespace Api\Enum;

class VehicleMessages
{
    const MORE_THAN         = 'This field must have %s or less characters';
    const NOT_BLANK         = 'This field cannot be blank';
    const INVALID_TYPE      = 'Invalid truck type';
    const INVALID_BRAND     = 'Invalid truck brand';
    const INVALID_MODEL     = 'Invalid truck model';
    const INVALID_CATEGORY  = 'Invalid truck category';
    const INVALID_PLATE     = 'Invalid truck plate';
}
