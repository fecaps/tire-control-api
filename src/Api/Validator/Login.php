<?php
declare(strict_types=1);

namespace Api\Validator;

use Api\Exception\ValidatorException;
use Api\Enum\UserMessages;

class Login implements ValidatorInterface
{
    public function validate(array $data)
    {
        $exception = new ValidatorException;

        $field = 'email';
        $this->validateEmail($field, $data[$field], $exception);

        $field = 'passwd';
        if (!isset($data[$field]) || $data[$field] == '') {
            $exception->addMessage($field, UserMessages::NOT_BLANK);
        }

        if (count($exception->getMessages()) > 0) {
            throw $exception;
        }
    }

    private function validateEmail($fieldName, $fieldValue, $exception)
    {
        if (!isset($fieldValue) || $fieldValue == '') {
            $exception->addMessage($fieldName, UserMessages::NOT_BLANK);
            return;
        }

        if (!filter_var($fieldValue, FILTER_VALIDATE_EMAIL)) {
            $exception->addMessage($fieldName, UserMessages::INVALID_EMAIL);
        }
    }
}
