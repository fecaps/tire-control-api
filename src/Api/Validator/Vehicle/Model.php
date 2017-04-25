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

        $this->validateNotEmpty('brand', $data['brand'], $exception);

        $this->validateModelFormat('model', $data['model'], self::MODEL_MAX_LEN, $exception);

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

    public function validateModelFormat($fieldName, $fieldValue, $limit, $exception)
    {
        if (!isset($fieldValue) || $fieldValue == '') {
            $exception->addMessage($fieldName, VehicleMessages::NOT_BLANK);
            return;
        }

        if (htmlentities($fieldValue, ENT_QUOTES, 'UTF-8') != $fieldValue) {
            $exception->addMessage($fieldName, VehicleMessages::INVALID_MODEL);
            return;
        }

        $this->validateMoreThan($fieldName, $fieldValue, self::MODEL_MAX_LEN, $exception);
    }

    public function validateMoreThan($fieldName, $fieldValue, $limit, $exception)
    {
        if (mb_strlen($fieldValue) > $limit) {
            $exception->addMessage($fieldName, sprintf(VehicleMessages::MORE_THAN, $limit));
        }
    }
}
