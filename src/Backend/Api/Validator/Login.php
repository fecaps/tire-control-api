<?php
declare(strict_types=1);

namespace Backend\Api\Validator;

use Backend\Api\Validator\ValidatorMessages;
use Backend\Api\Validator\ValidatorException;

class Login
{
    public function validateInputData(array $data)
    {
        $exception = new ValidatorException;

        if (!isset($data['email']) || $data['email'] == '') {
            $exception->addMessage('email', ValidatorMessages::NOT_BLANK);
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $exception->addMessage('email', ValidatorMessages::INVALID_EMAIL);
        }

        if (!isset($data['passwd']) || $data['passwd'] == '') {
            $exception->addMessage('passwd', ValidatorMessages::NOT_BLANK);
        }

        if (count($exception->getMessages()) > 0) {
            throw $exception;
        }
    }
}
