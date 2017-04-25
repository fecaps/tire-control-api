<?php
declare(strict_types=1);

namespace Api\Validator;

use PHPUnit\Framework\TestCase;
use Api\Exception\ValidatorException;
use Api\Enum\UserMessages;

class UserTest extends TestCase
{
    public function additionProvider()
    {
        $testData = [
            [
                ['name' => 'Paul', 'email' => 'paul@', 'username' => 'usernameÇ', 'passwd' => '1234567'],
                [
                    'name'      => [sprintf(UserMessages::LESS_THAN, User::NAME_MIN_LEN)],
                    'email'     => [UserMessages::INVALID_EMAIL],
                    'username'  => [UserMessages::INVALID_USERNAME],
                    'passwd'    => [sprintf(UserMessages::LESS_THAN, User::PASSWORD_MIN_LEN)]
                ]
            ],
            [
                ['name' => '', 'email' => '', 'username' => '', 'passwd' => ''],
                [
                    'name'      => [UserMessages::NOT_BLANK],
                    'email'     => [UserMessages::NOT_BLANK],
                    'username'  => [UserMessages::NOT_BLANK],
                    'passwd'    => [UserMessages::NOT_BLANK]
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
                    'name'      => [sprintf(UserMessages::MORE_THAN, User::NAME_MAX_LEN)],
                    'username'  => [sprintf(UserMessages::MORE_THAN, User::USERNAME_MAX_LEN)],
                    'passwd'    => [sprintf(UserMessages::MORE_THAN, User::PASSWORD_MAX_LEN)]
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
                    'passwd'    => '<p><script>alert("You cannot do whatever you want");</script></p>'
                ],
                [
                    'name'      => [UserMessages::INVALID_NAME],
                    'username'  => [UserMessages::INVALID_USERNAME],
                    'passwd'    => [UserMessages::INVALID_PASSWORD],
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
        $userValidator = new User();
        $messages = [];

        try {
            $userValidator->validate($testData);
        } catch (ValidatorException $e) {
            $messages = $e->getMessages();
        }

        $this->assertEquals($expectedData, $messages);
    }
}
