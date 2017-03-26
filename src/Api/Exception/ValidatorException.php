<?php
declare(strict_types=1);

namespace Api\Exception;

use UnexpectedValueException;

class ValidatorException extends UnexpectedValueException
{
    private $messages = [];

    public function addMessage($code, $message)
    {
        if (!isset($this->messages[$code])) {
            $this->messages[$code] = [];
        }

        $this->messages[$code][] = $message;

        return $this;
    }

    public function getMessages()
    {
        return $this->messages;
    }

    public function getFullMessage()
    {
        $message = '';

        foreach ($this->messages as $code => $messages) {
            $message.= $code . ': ' . implode(', ', $messages) . PHP_EOL;
        }

        return $message;
    }
}
