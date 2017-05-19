<?php
declare(strict_types=1);

namespace Api\Validator\Vehicle;

use Api\Exception\ValidatorException;
use Api\Enum\VehicleMessages;
use Api\Validator\ValidatorInterface;

class Model implements ValidatorInterface
{
    const MODEL_MAX_LEN = 50;
    
    public function validate(array $data)
    {
        $exception = new ValidatorException;

        $this->validateFormat('brand_id', $data['brand_id'], $exception, VehicleMessages::INVALID_BRAND);

        $field = 'model';
        $this->validateModelFormat($field, $data[$field], $exception);

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

    private function validateModelFormat($fieldName, $fieldValue, $exception)
    {
        if (!isset($fieldValue) || $fieldValue == '') {
            $exception->addMessage($fieldName, VehicleMessages::NOT_BLANK);
            return;
        }

        if (htmlentities($fieldValue, ENT_QUOTES, 'UTF-8') != $fieldValue) {
            $exception->addMessage($fieldName, VehicleMessages::INVALID_MODEL);
            return;
        }

        if (mb_strlen($fieldValue) > self::MODEL_MAX_LEN) {
            $exception->addMessage($fieldName, sprintf(VehicleMessages::MORE_THAN, self::MODEL_MAX_LEN));
        }
    }
}
