<?php
declare(strict_types=1);

namespace Api\Validator;

use PHPUnit\Framework\TestCase;
use Api\Exception\ValidatorException;

class ValidatorMessagesTest extends TestCase
{
    public function testShouldMessageAndGetMessages()
    {
        $validator = new ValidatorException('An error has ocorred.');

        $retrieveMessages = $validator
            ->addMessage(1, 'Test 1')
            ->addMessage(2, 'Test 2')
            ->addMessage(3, 'Test 3')
            ->addMessage(4, 'Test 4')
            ->addMessage(5, 'Test 5')
            ->addMessage(3, 'New Test 3')
            ->addMessage(4, 'New Test 4')
            ->addMessage(5, 'New Test 5')
            ->getMessages();

        $expectedMessages = [
            1 => ['Test 1'],
            2 => ['Test 2'],
            3 => ['Test 3', 'New Test 3'],
            4 => ['Test 4', 'New Test 4'],
            5 => ['Test 5', 'New Test 5']
        ];

        $this->assertEquals($expectedMessages, $retrieveMessages);

        $expectedFullMessages = '1: Test 1' . PHP_EOL .
            '2: Test 2' . PHP_EOL .
            '3: Test 3, New Test 3' . PHP_EOL .
            '4: Test 4, New Test 4' . PHP_EOL .
            '5: Test 5, New Test 5' . PHP_EOL;

        $this->assertEquals($expectedFullMessages, $validator->getFullMessage());
    }
}
