<?php
declare(strict_types=1);

namespace Api\Validator;

use Api\Exception\ValidatorException;
use Api\Enum\UserMessages;

class AuthSession implements ValidatorInterface
{
    public function validate(array $data)
    {
        $exception = new ValidatorException;
        
        $field = 'token';
        if (!isset($data[$field]) || $data[$field] == '') {
            $exception->addMessage($field, UserMessages::NOT_BLANK);
        }

        $this->validateDateTime($data, 'created_at', $exception);
        $this->validateDateTime($data, 'expire_at', $exception);

        $field = 'user_id';
        if (!isset($data[$field]) || $data[$field] == '') {
            $exception->addMessage($field, UserMessages::NOT_BLANK);
        }

        $field = 'user_ip';
        if (!isset($data[$field]) || $data[$field] == '') {
            $exception->addMessage($field, UserMessages::NOT_BLANK);
        } elseif (!filter_var($data[$field], FILTER_VALIDATE_IP)) {
            $exception->addMessage($field, UserMessages::INVALID_IP_ADDRESS);
        }

        if (count($exception->getMessages()) > 0) {
            throw $exception;
        }
    }

    public function validateDateTime($data, $field, $exception)
    {
        if (!isset($data[$field]) || $data[$field] == '') {
            $exception->addMessage($field, UserMessages::NOT_BLANK);
        } elseif (!strtotime($data[$field])) {
            $exception->addMessage($field, sprintf(UserMessages::INVALID_DATE_TIME, 'Y-m-d H:i:s'));
        }
    }
}
