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
        if (!isset($data[$field]) || $data[$field] == '') {
            $exception->addMessage($field, UserMessages::NOT_BLANK);
        } elseif (!filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
            $exception->addMessage($field, UserMessages::INVALID_EMAIL);
        }

        $field = 'passwd';
        if (!isset($data[$field]) || $data[$field] == '') {
            $exception->addMessage($field, UserMessages::NOT_BLANK);
        }

        if (count($exception->getMessages()) > 0) {
            throw $exception;
        }
    }
}
