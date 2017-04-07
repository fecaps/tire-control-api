<?php
declare(strict_types=1);

namespace Api\Validator;

use PHPUnit\Framework\TestCase;
use Api\Exception\ValidatorException;
use Api\Enum\UserMessages;

class AuthSessionTest extends TestCase
{
    public function additionProvider()
    {
        $testData = [
            [
                [
                    'token'         => '',
                    'created_at'    => '',
                    'expire_at'     => '',
                    'user_id'       => '',
                    'user_ip'       => ''
                ],
                [
                    'token'         => [UserMessages::NOT_BLANK],
                    'created_at'    => [UserMessages::NOT_BLANK],
                    'expire_at'     => [UserMessages::NOT_BLANK],
                    'user_id'       => [UserMessages::NOT_BLANK],
                    'user_ip'       => [UserMessages::NOT_BLANK]
                ]
            ],
            [
                [
                    'token'         => 'ABC123',
                    'created_at'    => 'This is not a datetime',
                    'expire_at'     => 'This is not a datetime',
                    'user_id'       => '1',
                    'user_ip'       => 'hh.jj.mm.ll'
                ],
                [
                    'created_at'    => [sprintf(UserMessages::INVALID_DATE_TIME, 'Y-m-d H:i:s')],
                    'expire_at'     => [sprintf(UserMessages::INVALID_DATE_TIME, 'Y-m-d H:i:s')],
                    'user_ip'       => [UserMessages::INVALID_IP_ADDRESS]
                ]
            ],
            [
                [
                    'token'         => 'ABC123',
                    'created_at'    => '2017-03-26 14:00:00',
                    'expire_at'     => '2017-03-26 14:00:00',
                    'user_id'       => '1',
                    'user_ip'       => '127.0.0.1'
                ],
                []
            ]
        ];

        return $testData;
    }

    /**
    * @dataProvider additionProvider
    */
    public function testShouldValidateData($testData, $expectedData)
    {
        $validator = new AuthSession;
        $messages = [];

        try {
            $validator->validate($testData);
        } catch (ValidatorException $exception) {
            $messages = $exception->getMessages();
        }

        $this->assertEquals($expectedData, $messages);
    }
}
