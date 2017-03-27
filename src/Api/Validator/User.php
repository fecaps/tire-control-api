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

        if (!isset($data['name']) || $data['name'] == '') {
            $exception->addMessage('name', ValidatorMessages::NOT_BLANK);
        } elseif (htmlentities($data['name'], ENT_QUOTES, 'UTF-8') != $data['name']) {
            $exception->addMessage('name', ValidatorMessages::INVALID_NAME);
        } elseif (filter_var($data['name'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_ENCODE_HIGH)) {
            $this->validateMoreThan('name', $data['name'], self::NAME_MAX_LEN, $exception);
            $this->validateLessThan('name', $data['name'], self::NAME_MIN_LEN, $exception);
        }

        if (!isset($data['username']) || $data['username'] == '') {
            $exception->addMessage('username', ValidatorMessages::NOT_BLANK);
        } elseif (htmlentities($data['username'], ENT_QUOTES, 'UTF-8') != $data['username']) {
            $exception->addMessage('username', ValidatorMessages::INVALID_USERNAME);
        } elseif (filter_var($data['username'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_ENCODE_HIGH)) {
            $this->validateLessThan('username', $data['username'], self::USERNAME_MIN_LEN, $exception);
            $this->validateMoreThan('username', $data['username'], self::USERNAME_MAX_LEN, $exception);
        }

        if (!isset($data['email']) || $data['email'] == '') {
            $exception->addMessage('email', ValidatorMessages::NOT_BLANK);
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $exception->addMessage('email', ValidatorMessages::INVALID_EMAIL);
        }

        if (!isset($data['passwd']) || $data['passwd'] == '') {
            $exception->addMessage('passwd', ValidatorMessages::NOT_BLANK);
        } else {
            $this->validateLessThan('passwd', $data['passwd'], self::PASSWORD_MIN_LEN, $exception);
            $this->validateMoreThan('passwd', $data['passwd'], self::PASSWORD_MAX_LEN, $exception);
        }

        if (count($exception->getMessages()) > 0) {
            throw $exception;
        }
    }

    public function validateLessThan($fieldName, $fieldValue, $limit, $exception)
    {
        if (strlen($fieldValue) < $limit) {
            $exception->addMessage($fieldName, sprintf(ValidatorMessages::LESS_THAN, $limit));
        }
    }

    public function validateMoreThan($fieldName, $fieldValue, $limit, $exception)
    {
        if (strlen($fieldValue) > $limit) {
            $exception->addMessage($fieldName, sprintf(ValidatorMessages::MORE_THAN, $limit));
        }
    }
}
