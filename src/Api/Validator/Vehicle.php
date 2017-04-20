<?php
declare(strict_types=1);

namespace Api\Validator;

use Api\Exception\ValidatorException;
use Api\Enum\VehicleMessages;

class Vehicle implements ValidatorInterface
{
    const MODEL_MAX_LEN = 50;
    const PLATE_LEN     = 6;

    public function validate(array $data)
    {
        $exception = new ValidatorException;

        $field = 'type';
        if (!isset($data[$field]) || $data[$field] == '') {
            $exception->addMessage($field, VehicleMessages::NOT_BLANK);
        }
        
        $field = 'brand';
        if (!isset($data[$field]) || $data[$field] == '') {
            $exception->addMessage($field, VehicleMessages::NOT_BLANK);
        }

        $field = 'category';
        if (!isset($data[$field]) || $data[$field] == '') {
            $exception->addMessage($field, VehicleMessages::NOT_BLANK);
        }

        $field = 'model';
        if (!isset($data[$field]) || $data[$field] == '') {
            $exception->addMessage($field, VehicleMessages::NOT_BLANK);
        } else {
            $this->validateUnicode($field, $data[$field], $exception, VehicleMessages::INVALID_MODEL);
            $this->validateMoreThan($field, $data[$field], self::MODEL_MAX_LEN, $exception);
        }

        $field = 'plate';
        if (!isset($data[$field]) || $data[$field] == '') {
            $exception->addMessage($field, VehicleMessages::NOT_BLANK);
        } else {
            $this->validatePlate($field, $data[$field], self::PLATE_LEN, $exception);
        }

        if (count($exception->getMessages()) > 0) {
            throw $exception;
        }
    }

    public function validateUnicode($fieldName, $fieldValue, $exception, $message)
    {
        if (htmlentities($fieldValue, ENT_QUOTES, 'UTF-8') != $fieldValue) {
            $exception->addMessage($fieldName, $message);
        }
    }

    public function validateMoreThan($fieldName, $fieldValue, $limit, $exception)
    {
        if (mb_strlen($fieldValue) > $limit) {
            $exception->addMessage($fieldName, sprintf(VehicleMessages::MORE_THAN, $limit));
        }
    }

    public function validatePlate($fieldName, $fieldValue, $limit, $exception)
    {
        if (htmlentities($fieldValue, ENT_QUOTES, 'UTF-8') != $fieldValue) {
            $exception->addMessage($fieldName, VehicleMessages::INVALID_PLATE);
        } else {
            if (mb_strlen($fieldValue) != $limit) {
                $exception->addMessage($fieldName, sprintf(VehicleMessages::SPECIFIC_LEN, $limit));
            } else {
                $numericPart = substr($fieldValue, -3);
                $stringPart = substr($fieldValue, -6, 3);
                if (!filter_var($numericPart, FILTER_VALIDATE_INT) ||
                    filter_var($stringPart, FILTER_VALIDATE_INT)) {
                    $exception->addMessage($fieldName, VehicleMessages::INVALID_PLATE);
                }
            }
        }
    }
}
