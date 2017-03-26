<?php
declare(strict_types=1);

namespace Api\Validator;

use Api\Exception\ValidatorException;

class AuthSession
{
    public function validate(array $data)
    {
        $exception = new ValidatorException;
        
        if (!isset($data['token']) || $data['token'] == '') {
            $exception->addMessage('token', ValidatorMessages::NOT_BLANK);
        }

        $this->validateDateTime($data, 'created_at', $exception);
        $this->validateDateTime($data, 'expire_at', $exception);

        if (!isset($data['user_id']) || $data['user_id'] == '') {
            $exception->addMessage('user_id', ValidatorMessages::NOT_BLANK);
        }

        if (!isset($data['user_ip']) || $data['user_ip'] == '') {
            $exception->addMessage('user_ip', ValidatorMessages::NOT_BLANK);
        } elseif (!filter_var($data['user_ip'], FILTER_VALIDATE_IP)) {
            $exception->addMessage('user_ip', ValidatorMessages::INVALID_IP_ADDRESS);
        }

        if (count($exception->getMessages()) > 0) {
            throw $exception;
        }
    }

    public function validateDateTime($data, $field, $exception)
    {
        if (!isset($data[$field]) || $data[$field] == '') {
            $exception->addMessage($field, ValidatorMessages::NOT_BLANK);
        } elseif (!strtotime($data[$field])) {
            $exception->addMessage($field, sprintf(ValidatorMessages::INVALID_DATE_TIME, 'Y-m-d H:i:s'));
        }
    }
}
