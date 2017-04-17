<?php
declare(strict_types=1);

namespace Api\Validator;

use Api\Exception\ValidatorException;
use Api\Enum\TireMessages;

class Tire implements ValidatorInterface
{
    const DOT_LEN   = 4;
    const CODE_LEN  = 6;
    
    public function validate(array $data)
    {
        $exception = new ValidatorException;

        $field = 'brand';
        if (!isset($data[$field]) || $data[$field] == '') {
            $exception->addMessage($field, TireMessages::NOT_BLANK);
        }

        $field = 'model';
        if (!isset($data[$field]) || $data[$field] == '') {
            $exception->addMessage($field, TireMessages::NOT_BLANK);
        }

        $field = 'size';
        if (!isset($data[$field]) || $data[$field] == '') {
            $exception->addMessage($field, TireMessages::NOT_BLANK);
        }

        $field = 'type';
        if (!isset($data[$field]) || $data[$field] == '') {
            $exception->addMessage($field, TireMessages::NOT_BLANK);
        }

        $field = 'dot';
        if (!isset($data[$field]) || $data[$field] == '') {
            $exception->addMessage($field, TireMessages::NOT_BLANK);
        } else {
            $this->validateUnicode($field, $data[$field], $exception, TireMessages::INVALID_DOT);
            $this->validateLength($field, $data[$field], self::DOT_LEN, $exception);
        }

        $field = 'code';
        if (!isset($data[$field]) || $data[$field] == '') {
            $exception->addMessage($field, TireMessages::NOT_BLANK);
        } else {
            $this->validateUnicode($field, $data[$field], $exception, TireMessages::INVALID_CODE);
            $this->validateLength($field, $data[$field], self::CODE_LEN, $exception);
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
    
    public function validateLength($fieldName, $fieldValue, $limit, $exception)
    {
        if (mb_strlen($fieldValue) != $limit) {
            $exception->addMessage($fieldName, sprintf(TireMessages::SPECIFIC_LEN, $limit));
        }
    }
}
