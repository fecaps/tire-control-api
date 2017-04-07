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

        $field = 'size';
        if (!isset($data[$field]) || $data[$field] == '') {
            $exception->addMessage($field, TireMessages::NOT_BLANK);
        } else {
            $this->validateUnicode($field, $data[$field], $exception, TireMessages::INVALID_SIZE);
            $this->validateLessThan($field, $data[$field], self::SIZE_MIN_LEN, $exception);
            $this->validateMoreThan($field, $data[$field], self::SIZE_MAX_LEN, $exception);
        }

        if (count($exception->getMessages()) > 0) {
            throw $exception;
        }
    }

    public function validateUnicode($fieldName, $fieldValue, $exception, $message)
    {
        if (htmlentities($fieldValue, ENT_QUOTES, 'UTF-8') != $fieldValue) {
            $exception->addMessage($fieldName, $message);
        }
    }
    
    public function validateLessThan($fieldName, $fieldValue, $limit, $exception)
    {
        if (mb_strlen($fieldValue) < $limit) {
            $exception->addMessage($fieldName, sprintf(TireMessages::LESS_THAN, $limit));
        }
    }

    public function validateMoreThan($fieldName, $fieldValue, $limit, $exception)
    {
        if (mb_strlen($fieldValue) > $limit) {
            $exception->addMessage($fieldName, sprintf(TireMessages::MORE_THAN, $limit));
        }
    }
}
