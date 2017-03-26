<?php
declare(strict_types=1);

namespace Api\Validator;

use PHPUnit\Framework\TestCase;
use Api\Validator\ValidatorException;
use Api\Validator\ValidatorMessages;

class LoginTest extends TestCase
{
    public function testData()
    {
        $testData = [
            [
                ['email' => '', 'passwd' => ''],
                [
                    'email' => [ValidatorMessages::NOT_BLANK],
                    'passwd' => [ValidatorMessages::NOT_BLANK]
                ]
            ],
            [
                ['email' => 'paul@', 'passwd' => ''],
                [
                    'email' => [ValidatorMessages::INVALID_EMAIL],
                    'passwd' => [ValidatorMessages::NOT_BLANK]
                ]
            ],
            [
                [
                    'email' => 'paul@gmail.com',
                    'passwd' => 'avalidpasswd'
                ],
                [
                ]
            ]
        ];

        return $testData;
    }

    /**
     * @dataProvider testData
     */
    public function testShouldThrowValidatorExceptionOnInvalidaData($testData, $expectedData)
    {
        $loginValidator = new Login();
        $messages = [];

        try {
            $loginValidator->validateInputData($testData);
        } catch (ValidatorException $e) {
            $messages = $e->getMessages();
        }

        $this->assertEquals($expectedData, $messages);
    }
}
