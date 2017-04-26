<?php
declare(strict_types=1);

namespace Api\Validator\Tire;

use Api\Exception\ValidatorException;
use Api\Enum\TireMessages;
use Api\Validator\ValidatorInterface;

class Type implements ValidatorInterface
{
    const TYPE_MIN_LEN = 4;
    const TYPE_MAX_LEN = 50;
    
    public function validate(array $data)
    {
        $exception = new ValidatorException;

        $field = 'name';
        if (!isset($data[$field]) || $data[$field] == '') {
            $exception->addMessage($field, TireMessages::NOT_BLANK);
            throw $exception;
        }

        if (htmlentities($data[$field], ENT_QUOTES, 'UTF-8') != $data[$field]) {
            $exception->addMessage($field, TireMessages::INVALID_TYPE);
            throw $exception;
        }

        if (mb_strlen($data[$field]) < self::TYPE_MIN_LEN) {
            $exception->addMessage($field, sprintf(TireMessages::LESS_THAN, self::TYPE_MIN_LEN));
            throw $exception;
        }

        if (mb_strlen($data[$field]) > self::TYPE_MAX_LEN) {
            $exception->addMessage($field, sprintf(TireMessages::MORE_THAN, self::TYPE_MAX_LEN));
            throw $exception;
        }
    }
}
