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

        $this->validateNotEmpty('brand', $data['brand'], $exception);

        $this->validateNotEmpty('model', $data['model'], $exception);

        $this->validateNotEmpty('size', $data['size'], $exception);

        $this->validateNotEmpty('type', $data['type'], $exception);

        $this->validateFormats('dot', $data['dot'], self::DOT_LEN, TireMessages::INVALID_DOT, $exception);

        $this->validateFormats('code', $data['code'], self::CODE_LEN, TireMessages::INVALID_CODE, $exception);

        if (count($exception->getMessages()) > 0) {
            throw $exception;
        }
    }

    private function validateNotEmpty($fieldName, $fieldValue, $exception)
    {
        if (!isset($fieldValue) || $fieldValue == '') {
            $exception->addMessage($fieldName, TireMessages::NOT_BLANK);
        }
    }

    private function validateFormats($fieldName, $fieldValue, $limit, $invalidMessage, $exception)
    {
        $blankMessage = TireMessages::NOT_BLANK;

        if (!isset($fieldValue) || $fieldValue == '') {
            $exception->addMessage($fieldName, $blankMessage);
            return;
        }

        if (htmlentities($fieldValue, ENT_QUOTES, 'UTF-8') != $fieldValue) {
            $exception->addMessage($fieldName, $invalidMessage);
            return;
        }

        if (mb_strlen($fieldValue) != $limit) {
            $exception->addMessage($fieldName, sprintf(TireMessages::SPECIFIC_LEN, $limit));
        }
    }
}
