<?php
declare(strict_types=1);

namespace Api\Validator;

use Api\Exception\ValidatorException;

class User implements ValidatorInterface
{
    const NAME_MIN_LEN      = 5;
    const USERNAME_MIN_LEN  = 5;
    const PASSWORD_MIN_LEN  = 8;
    const NAME_MAX_LEN      = 255;
    const USERNAME_MAX_LEN  = 255;
    const PASSWORD_MAX_LEN  = 255;

    public function validate(array $data)
    {
        $exception = new ValidatorException;

        $field = 'name';
        if (!isset($data[$field]) || $data[$field] == '') {
            $exception->addMessage($field, ValidatorMessages::NOT_BLANK);
        } else {
            $this->validateUnicode($field, $data[$field], $exception, ValidatorMessages::INVALID_NAME);
            $this->validateMoreThan($field, $data[$field], self::NAME_MAX_LEN, $exception);
            $this->validateLessThan($field, $data[$field], self::NAME_MIN_LEN, $exception);
        }

        $field = 'username';
        if (!isset($data[$field]) || $data[$field] == '') {
            $exception->addMessage($field, ValidatorMessages::NOT_BLANK);
        } else {
            $this->validateUnicode($field, $data[$field], $exception, ValidatorMessages::INVALID_USERNAME);
            $this->validateLessThan($field, $data[$field], self::USERNAME_MIN_LEN, $exception);
            $this->validateMoreThan($field, $data[$field], self::USERNAME_MAX_LEN, $exception);
        }

        $field = 'email';
        if (!isset($data[$field]) || $data[$field] == '') {
            $exception->addMessage($field, ValidatorMessages::NOT_BLANK);
        } elseif (!filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
            $exception->addMessage($field, ValidatorMessages::INVALID_EMAIL);
        }

        $field = 'passwd';
        if (!isset($data[$field]) || $data[$field] == '') {
            $exception->addMessage($field, ValidatorMessages::NOT_BLANK);
        } else {
            $this->validateLessThan($field, $data[$field], self::PASSWORD_MIN_LEN, $exception);
            $this->validateMoreThan($field, $data[$field], self::PASSWORD_MAX_LEN, $exception);
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
            $exception->addMessage($fieldName, sprintf(ValidatorMessages::LESS_THAN, $limit));
        }
    }

    public function validateMoreThan($fieldName, $fieldValue, $limit, $exception)
    {
        if (mb_strlen($fieldValue) > $limit) {
            $exception->addMessage($fieldName, sprintf(ValidatorMessages::MORE_THAN, $limit));
        }
    }
}
