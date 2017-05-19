<?php
declare(strict_types=1);

namespace Api\Validator\Tire;

use Api\Exception\ValidatorException;
use Api\Validator\ValidatorInterface;
use Api\Enum\TireMessages;
use DateTime;

class Tire implements ValidatorInterface
{
    const DOT_LEN   = 4;
    const CODE_LEN  = 6;
    
    public function validate(array $data)
    {
        $exception = new ValidatorException;

        $this->validateFormat('brand_id', $data['brand_id'], $exception, TireMessages::INVALID_BRAND);

        $this->validateFormat('model_id', $data['model_id'], $exception, TireMessages::INVALID_MODEL);

        $this->validateFormat('size_id', $data['size_id'], $exception, TireMessages::INVALID_SIZE);

        $this->validateFormat('type_id', $data['type_id'], $exception, TireMessages::INVALID_TYPE);

        $this->validateDotAndCode('dot', $data['dot'], self::DOT_LEN, TireMessages::INVALID_DOT, $exception);

        $this->validateDotAndCode('code', $data['code'], self::CODE_LEN, TireMessages::INVALID_CODE, $exception);

        $this->validatePurchasePrice('purchase_price', $data['purchase_price'], $exception);

        $this->validatePurchaseDate('purchase_date', $data['purchase_date'], $exception);

        if (count($exception->getMessages()) > 0) {
            throw $exception;
        }
    }

    private function validateFormat($fieldName, $fieldValue, $exception, $message)
    {
        if (!isset($fieldValue) || $fieldValue == '') {
            $exception->addMessage($fieldName, TireMessages::NOT_BLANK);
            return;
        }

        if (!is_int($fieldValue)) {
            $exception->addMessage($fieldName, $message);
        }
    }

    private function validateDotAndCode($fieldName, $fieldValue, $limit, $invalidMessage, $exception)
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

    private function validatePurchasePrice($fieldName, $fieldValue, $exception)
    {
        $blankMessage   = TireMessages::NOT_BLANK;
        $invalidMessage = TireMessages::INVALID_PURCHASE_PRICE;

        if (!isset($fieldValue) || $fieldValue == '') {
            $exception->addMessage($fieldName, $blankMessage);
            return;
        }

        if (!filter_var($fieldValue, FILTER_VALIDATE_FLOAT)) {
            $exception->addMessage($fieldName, $invalidMessage);
        }
    }

    private function validatePurchaseDate($fieldName, $fieldValue, $exception)
    {
        $blankMessage   = TireMessages::NOT_BLANK;
        $invalidMessage = TireMessages::INVALID_PURCHASE_DATE;

        if (!isset($fieldValue) || $fieldValue == '') {
            $exception->addMessage($fieldName, $blankMessage);
            return;
        }

        if (!is_string($fieldValue)) {
            $exception->addMessage($fieldName, $invalidMessage);
            return;
        }

        if (!DateTime::createFromFormat('Y-m-d', $fieldValue)) {
            $exception->addMessage($fieldName, $invalidMessage);
            return;
        }

        $day    = substr($fieldValue, -2);
        $month  = substr($fieldValue, -5, 2);
        $year   = substr($fieldValue, -10, 4);

        if (!checkdate((int)$month, (int)$day, (int)$year)) {
            $exception->addMessage($fieldName, $invalidMessage);
        }
    }
}
