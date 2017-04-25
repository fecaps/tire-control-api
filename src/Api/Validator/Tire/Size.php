<?php
declare(strict_types=1);

namespace Api\Validator\Tire;

use Api\Exception\ValidatorException;
use Api\Enum\TireMessages;
use Api\Validator\ValidatorInterface;

class Size implements ValidatorInterface
{
    const SIZE_MIN_LEN = 4;
    const SIZE_MAX_LEN = 50;
    
    public function validate(array $data)
    {
        $exception = new ValidatorException;

        $field = 'name';
        if (!isset($data[$field]) || $data[$field] == '') {
            $exception->addMessage($field, TireMessages::NOT_BLANK);
            throw $exception;
        }

        if (htmlentities($data[$field], ENT_QUOTES, 'UTF-8') != $data[$field]) {
            $exception->addMessage($field, TireMessages::INVALID_SIZE);
            throw $exception;
        }

        $this->validateLessThan($field, $data[$field], self::SIZE_MIN_LEN, $exception);
        $this->validateMoreThan($field, $data[$field], self::SIZE_MAX_LEN, $exception);
    }

    public function validateLessThan($fieldName, $fieldValue, $limit, $exception)
    {
        if (mb_strlen($fieldValue) < $limit) {
            $exception->addMessage($fieldName, sprintf(TireMessages::LESS_THAN, $limit));
            throw $exception;
        }
    }

    public function validateMoreThan($fieldName, $fieldValue, $limit, $exception)
    {
        if (mb_strlen($fieldValue) > $limit) {
            $exception->addMessage($fieldName, sprintf(TireMessages::MORE_THAN, $limit));
            throw $exception;
        }
    }
}
