<?php
declare(strict_types=1);

namespace Api\Validator;

use Api\Exception\ValidatorException;
use Api\Enum\UserMessages;

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

        $this->validateFormats(
            'name',
            $data['name'],
            UserMessages::INVALID_NAME,
            self::NAME_MAX_LEN,
            self::NAME_MIN_LEN,
            $exception
        );

        $this->validateFormats(
            'username',
            $data['username'],
            UserMessages::INVALID_USERNAME,
            self::USERNAME_MAX_LEN,
            self::USERNAME_MIN_LEN,
            $exception
        );
        
        $this->validateEmail(
            'email',
            $data['email'],
            UserMessages::INVALID_EMAIL,
            $exception
        );

        $this->validateFormats(
            'passwd',
            $data['passwd'],
            UserMessages::INVALID_PASSWORD,
            self::PASSWORD_MAX_LEN,
            self::PASSWORD_MIN_LEN,
            $exception
        );

        if (count($exception->getMessages()) > 0) {
            throw $exception;
        }
    }
    
    public function validateFormats($fieldName, $fieldValue, $invalidMessage, $maxLen, $minLen, $exception)
    {
        $blankMessage = UserMessages::NOT_BLANK;

        if (!isset($fieldValue) || $fieldValue == '') {
            $exception->addMessage($fieldName, $blankMessage);
            return;
        }

        if (htmlentities($fieldValue, ENT_QUOTES, 'UTF-8') != $fieldValue) {
            $exception->addMessage($fieldName, $invalidMessage);
            return;
        }

        $this->validateMoreThan($fieldName, $fieldValue, $maxLen, $exception);
        $this->validateLessThan($fieldName, $fieldValue, $minLen, $exception);
    }

    public function validateLessThan($fieldName, $fieldValue, $limit, $exception)
    {
        if (mb_strlen($fieldValue) < $limit) {
            $exception->addMessage($fieldName, sprintf(UserMessages::LESS_THAN, $limit));
        }
    }

    public function validateMoreThan($fieldName, $fieldValue, $limit, $exception)
    {
        if (mb_strlen($fieldValue) > $limit) {
            $exception->addMessage($fieldName, sprintf(UserMessages::MORE_THAN, $limit));
        }
    }

    public function validateEmail($fieldName, $fieldValue, $invalidMessage, $exception)
    {
        $blankMessage = UserMessages::NOT_BLANK;

        if (!isset($fieldValue) || $fieldValue == '') {
            $exception->addMessage($fieldName, $blankMessage);
            return;
        }

        if (!filter_var($fieldValue, FILTER_VALIDATE_EMAIL)) {
            $exception->addMessage($fieldName, $invalidMessage);
        }
    }
}
