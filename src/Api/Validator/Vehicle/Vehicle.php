<?php
declare(strict_types=1);

namespace Api\Validator\Vehicle;

use Api\Exception\ValidatorException;
use Api\Validator\ValidatorInterface;
use Api\Enum\VehicleMessages;

class Vehicle implements ValidatorInterface
{
    const PLATE_LEN = 6;

    public function validate(array $data)
    {
        $exception = new ValidatorException;

        $this->validateFormat('brand_id', $data['brand_id'], $exception, VehicleMessages::INVALID_BRAND);

        $this->validateFormat('category_id', $data['category_id'], $exception, VehicleMessages::INVALID_CATEGORY);

        $this->validateFormat('model_id', $data['model_id'], $exception, VehicleMessages::INVALID_MODEL);

        $this->validateFormat('type_id', $data['type_id'], $exception, VehicleMessages::INVALID_TYPE);

        $this->validatePlate('plate', $data['plate'], self::PLATE_LEN, $exception);

        if (count($exception->getMessages()) > 0) {
            throw $exception;
        }
    }

    private function validateFormat($fieldName, $fieldValue, $exception, $message)
    {
        if (!isset($fieldValue) || $fieldValue == '') {
            $exception->addMessage($fieldName, VehicleMessages::NOT_BLANK);
            return;
        }

        if (!is_int($fieldValue)) {
            $exception->addMessage($fieldName, $message);
        }
    }

    private function validatePlate($fieldName, $fieldValue, $limit, $exception)
    {
        $blankMessage   = VehicleMessages::NOT_BLANK;
        $invalidMessage = VehicleMessages::INVALID_PLATE;

        if (!isset($fieldValue) || $fieldValue == '') {
            $exception->addMessage($fieldName, $blankMessage);
            return;
        }

        if (htmlentities($fieldValue, ENT_QUOTES, 'UTF-8') != $fieldValue) {
            $exception->addMessage($fieldName, $invalidMessage);
            return;
        }

        if (mb_strlen($fieldValue) != $limit) {
            $exception->addMessage($fieldName, sprintf(VehicleMessages::SPECIFIC_LEN, $limit));
            return;
        }

        $numericPart = substr($fieldValue, -3);
        $stringPart = substr($fieldValue, -6, 3);
        if (!filter_var($numericPart, FILTER_VALIDATE_INT) || filter_var($stringPart, FILTER_VALIDATE_INT)) {
            $exception->addMessage($fieldName, $invalidMessage);
        }
    }
}
