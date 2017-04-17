<?php
declare(strict_types=1);

namespace Api\Validator;

use PHPUnit\Framework\TestCase;
use Api\Exception\ValidatorException;
use Api\Enum\TireMessages;

class TireTest extends TestCase
{
    public function additionProvider()
    {
        $testData = [
            [
                [
                    'brand' => '',
                    'model' => '',
                    'size'  => '',
                    'type'  => '',
                    'dot'   => '',
                    'code'  => ''
                ],
                [
                    'brand' => [TireMessages::NOT_BLANK],
                    'model' => [TireMessages::NOT_BLANK],
                    'size'  => [TireMessages::NOT_BLANK],
                    'type'  => [TireMessages::NOT_BLANK],
                    'dot'   => [TireMessages::NOT_BLANK],
                    'code'  => [TireMessages::NOT_BLANK]
                ]
            ],
            [
                [
                    'brand' => 'Brand1',
                    'model' => 'Model1',
                    'size'  => 'Size1',
                    'type'  => 'Type1',
                    'dot'   => str_pad('A', Tire::DOT_LEN + 1),
                    'code'  => str_pad('A', Tire::CODE_LEN + 1)
                ],
                [
                    'dot'   => [sprintf(TireMessages::SPECIFIC_LEN, Tire::DOT_LEN)],
                    'code'  => [sprintf(TireMessages::SPECIFIC_LEN, Tire::CODE_LEN)]
                ]
            ],
            [
                [
                    'brand' => 'Brand2',
                    'model' => 'Model2',
                    'size'  => 'Size2',
                    'type'  => 'Type2',
                    'dot'   => str_pad('A', Tire::DOT_LEN - 1),
                    'code'  => str_pad('A', Tire::CODE_LEN - 1)
                ],
                [
                    'dot'   => [sprintf(TireMessages::SPECIFIC_LEN, Tire::DOT_LEN)],
                    'code'  => [sprintf(TireMessages::SPECIFIC_LEN, Tire::CODE_LEN)]
                ]
            ],
            [
                [
                    'brand' => 'Brand3',
                    'model' => 'Model3',
                    'size'  => 'Size3',
                    'type'  => 'Type3',
                    'dot'   => '<ps>',
                    'code'  => '<scpt>'
                ],
                [
                    'dot'   => [TireMessages::INVALID_DOT],
                    'code'  => [TireMessages::INVALID_CODE]
                ]
            ],
            [
                [
                    'brand' => 'Brand4',
                    'model' => 'Model4',
                    'size'  => 'Size4',
                    'type'  => 'Type4',
                    'dot'   => '4444',
                    'code'  => '666666'
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
        $tireValidator = new Tire();
        $messages = [];

        try {
            $tireValidator->validate($testData);
        } catch (ValidatorException $exception) {
            $messages = $exception->getMessages();
        }

        $this->assertEquals($expectedData, $messages);
    }
}
