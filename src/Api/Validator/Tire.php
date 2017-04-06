<?php
declare(strict_types=1);

namespace Api\Validator;

use Api\Exception\ValidatorException;

class Tire implements ValidatorInterface
{
    const TYPE_MAX_LEN      = 50;
    const BRAND_MAX_LEN     = 50;
    const NOTE_MAX_LEN      = 255;
    const SITUATION_MAX_LEN = 255;
    
    public function validate(array $data)
    {
        $exception = new ValidatorException;

        $field = 'type';
        if (!isset($data[$field]) || $data[$field] == '') {
            $exception->addMessage($field, ValidatorMessages::NOT_BLANK);
        } else {
            $this->validateUnicode($field, $data[$field], $exception, ValidatorMessages::INVALID_TYPE);
            $this->validateMoreThan($field, $data[$field], self::TYPE_MAX_LEN, $exception);
        }

        $field = 'brand';
        if (!isset($data[$field]) || $data[$field] == '') {
            $exception->addMessage($field, ValidatorMessages::NOT_BLANK);
        } else {
            $this->validateUnicode($field, $data[$field], $exception, ValidatorMessages::INVALID_BRAND);
            $this->validateMoreThan($field, $data[$field], self::BRAND_MAX_LEN, $exception);
        }

        $field = 'durability';
        if (!isset($data[$field]) || $data[$field] == '') {
            $exception->addMessage($field, ValidatorMessages::NOT_BLANK);
        } elseif (!is_int($data[$field])) {
            $exception->addMessage($field, ValidatorMessages::INVALID_DURABILITY);
        }

        $field = 'cost';
        if (!isset($data[$field]) || $data[$field] == '') {
            $exception->addMessage($field, ValidatorMessages::NOT_BLANK);
        } elseif (!is_float($data[$field])) {
            $exception->addMessage($field, ValidatorMessages::INVALID_COST);
        }

        $field = 'note';
        if (isset($data[$field])) {
            $this->validateUnicode($field, $data[$field], $exception, ValidatorMessages::INVALID_NOTE);
            $this->validateMoreThan($field, $data[$field], self::NOTE_MAX_LEN, $exception);
        }

        $field = 'situation';
        if (!isset($data[$field]) || $data[$field] == '') {
            $exception->addMessage($field, ValidatorMessages::NOT_BLANK);
        } else {
            $this->validateUnicode($field, $data[$field], $exception, ValidatorMessages::INVALID_SITUATION);
            $this->validateMoreThan($field, $data[$field], self::SITUATION_MAX_LEN, $exception);
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
    
    public function validateMoreThan($fieldName, $fieldValue, $limit, $exception)
    {
        if (mb_strlen($fieldValue) > $limit) {
            $exception->addMessage($fieldName, sprintf(ValidatorMessages::MORE_THAN, $limit));
        }
    }
}
