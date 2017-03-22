<?php
declare(strict_types=1);

namespace Backend\Api\Validator;

use PHPUnit\Framework\TestCase;
use Backend\Api\Validator\ValidatorException;
use Backend\Api\Validator\ValidatorMessages;

class UserTest extends TestCase
{
    public function testData()
    {
        $testData = [
            [
                ['name' => 'Paul', 'email' => 'paul@', 'username' => 'usernameÇ', 'passwd' => '1234567'],
                [
                    'name'      => [sprintf(ValidatorMessages::LESS_THAN, User::NAME_MIN_LEN)],
                    'email'     => [ValidatorMessages::INVALID_EMAIL],
                    'username'  => [ValidatorMessages::INVALID_USERNAME],
                    'passwd'    => [sprintf(ValidatorMessages::LESS_THAN, User::PASSWORD_MIN_LEN)]
                ]
            ],
            [
                ['name' => '', 'email' => '', 'username' => ''],
                [
                    'name'      => [ValidatorMessages::NOT_BLANK],
                    'email'     => [ValidatorMessages::NOT_BLANK],
                    'username'  => [ValidatorMessages::NOT_BLANK],
                    'passwd'    => [ValidatorMessages::NOT_BLANK]
                ]
            ],
            [
                [
                    'name'      => str_pad('A', User::NAME_MAX_LEN + 1),
                    'email'     => 'paul@gmail.com',
                    'username'  => str_pad('paulUsername', User::USERNAME_MAX_LEN + 1),
                    'passwd'    => str_pad('A', User::PASSWORD_MAX_LEN + 1)
                ],
                [
                    'name'      => [sprintf(ValidatorMessages::MORE_THAN, User::NAME_MAX_LEN)],
                    'username'  => [sprintf(ValidatorMessages::MORE_THAN, User::USERNAME_MAX_LEN)],
                    'passwd'    => [sprintf(ValidatorMessages::MORE_THAN, User::PASSWORD_MAX_LEN)]
                ]
            ],
            [
                [
                    'name'      => 'Paul name',
                    'email'     => 'paul@gmail.com',
                    'username'  => 'paulUsername',
                    'passwd'    => 'avalidpasswd'
                ],
                [
                ]
            ],
            [
                [
                    'name'      => '<p><script>window.location.href="http://example.com";</script></p>',
                    'email'     => 'paul@gmail.com',
                    'username'  => '<p><script>alert("You cannot do whatever you want");</script></p>',
                    'passwd'    => 'avalidpasswd'
                ],
                [
                    'name'      => [ValidatorMessages::INVALID_NAME],
                    'username'  => [ValidatorMessages::INVALID_USERNAME]
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
        $userValidator = new User();
        $messages = [];

        try {
            $userValidator->sanitizeInputData($testData);
        } catch (ValidatorException $e) {
            $messages = $e->getMessages();
        }

        $this->assertEquals($expectedData, $messages);
    }
}
