<?php
declare(strict_types=1);

namespace Api\Validator;

use PHPUnit\Framework\TestCase;
use Api\Exception\ValidatorException;
use Api\Enum\UserMessages;

class LoginTest extends TestCase
{
    public function additionProvider()
    {
        $testData = [
            [
                ['email' => '', 'passwd' => ''],
                [
                    'email'     => [UserMessages::NOT_BLANK],
                    'passwd'    => [UserMessages::NOT_BLANK]
                ]
            ],
            [
                ['email' => 'paul@', 'passwd' => ''],
                [
                    'email'     => [UserMessages::INVALID_EMAIL],
                    'passwd'    => [UserMessages::NOT_BLANK]
                ]
            ],
            [
                [
                    'email'     => 'paul@gmail.com',
                    'passwd'    => 'avalidpasswd'
                ],
                [
                ]
            ]
        ];

        return $testData;
    }

    /**
     * @dataProvider additionProvider
     */
    public function testShouldThrowValidatorExceptionOnInvalidaData($testData, $expectedData)
    {
        $loginValidator = new Login();
        $messages = [];

        try {
            $loginValidator->validate($testData);
        } catch (ValidatorException $e) {
            $messages = $e->getMessages();
        }

        $this->assertEquals($expectedData, $messages);
    }
}
