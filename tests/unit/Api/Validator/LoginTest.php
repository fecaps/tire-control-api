<?php
declare(strict_types=1);

namespace Api\Validator;

use PHPUnit\Framework\TestCase;
use Api\Exception\ValidatorException;

class LoginTest extends TestCase
{
    public function additionProvider()
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
