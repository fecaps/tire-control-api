<?php
declare(strict_types=1);

namespace Api\Validator;

use PHPUnit\Framework\TestCase;

class AuthSessionTest extends TestCase
{
    public function testData()
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
                    'token'         => [ValidatorMessages::NOT_BLANK],
                    'created_at'    => [ValidatorMessages::NOT_BLANK],
                    'expire_at'     => [ValidatorMessages::NOT_BLANK],
                    'user_id'       => [ValidatorMessages::NOT_BLANK],
                    'user_ip'       => [ValidatorMessages::NOT_BLANK]
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
                    'created_at'    => [sprintf(ValidatorMessages::INVALID_DATE_TIME, 'Y-m-d H:i:s')],
                    'expire_at'     => [sprintf(ValidatorMessages::INVALID_DATE_TIME, 'Y-m-d H:i:s')],
                    'user_ip'       => [ValidatorMessages::INVALID_IP_ADDRESS]
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
    * @dataProvider testData
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
