<?php
declare(strict_types=1);

namespace Api\Validator;

use Api\Exception\ValidatorException;
use Api\Enum\VehicleMessages;

class Vehicle implements ValidatorInterface
{
    const PLATE_LEN = 6;

    public function validate(array $data)
    {
        $exception = new ValidatorException;

        $this->validateNotEmpty('type', $data['type'], $exception);
        
        $this->validateNotEmpty('brand', $data['brand'], $exception);

        $this->validateNotEmpty('category', $data['category'], $exception);

        $this->validateNotEmpty('model', $data['model'], $exception);

        $this->validatePlate('plate', $data['plate'], self::PLATE_LEN, $exception);

        if (count($exception->getMessages()) > 0) {
            throw $exception;
        }
    }

    public function validateNotEmpty($fieldName, $fieldValue, $exception)
    {
        if (!isset($fieldValue) || $fieldValue == '') {
            $exception->addMessage($fieldName, VehicleMessages::NOT_BLANK);
        }
    }

    public function validatePlate($fieldName, $fieldValue, $limit, $exception)
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
            return;
        }
    }
}
