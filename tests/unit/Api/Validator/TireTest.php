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
                    'brand'             => '',
                    'model'             => '',
                    'size'              => '',
                    'type'              => '',
                    'dot'               => '',
                    'code'              => '',
                    'purchase_date'     => '',
                    'purchase_price'    => ''
                ],
                [
                    'brand'             => [TireMessages::NOT_BLANK],
                    'model'             => [TireMessages::NOT_BLANK],
                    'size'              => [TireMessages::NOT_BLANK],
                    'type'              => [TireMessages::NOT_BLANK],
                    'dot'               => [TireMessages::NOT_BLANK],
                    'code'              => [TireMessages::NOT_BLANK],
                    'purchase_date'     => [TireMessages::NOT_BLANK],
                    'purchase_price'    => [TireMessages::NOT_BLANK]
                ]
            ],
            [
                [
                    'brand'             => 'Brand1',
                    'model'             => 'Model1',
                    'size'              => 'Size1',
                    'type'              => 'Type1',
                    'dot'               => str_pad('A', Tire::DOT_LEN + 1),
                    'code'              => str_pad('A', Tire::CODE_LEN + 1),
                    'purchase_date'     => 20161217,
                    'purchase_price'    => 'It cannot be a text'
                ],
                [
                    'dot'               => [sprintf(TireMessages::SPECIFIC_LEN, Tire::DOT_LEN)],
                    'code'              => [sprintf(TireMessages::SPECIFIC_LEN, Tire::CODE_LEN)],
                    'purchase_date'     => [TireMessages::INVALID_PURCHASE_DATE],
                    'purchase_price'    => [TireMessages::INVALID_PURCHASE_PRICE]
                ]
            ],
            [
                [
                    'brand'             => 'Brand2',
                    'model'             => 'Model2',
                    'size'              => 'Size2',
                    'type'              => 'Type2',
                    'dot'               => str_pad('A', Tire::DOT_LEN - 1),
                    'code'              => str_pad('A', Tire::CODE_LEN - 1),
                    'purchase_date'     => 'It cannot be a text',
                    'purchase_price'    => 17
                ],
                [
                    'dot'               => [sprintf(TireMessages::SPECIFIC_LEN, Tire::DOT_LEN)],
                    'code'              => [sprintf(TireMessages::SPECIFIC_LEN, Tire::CODE_LEN)],
                    'purchase_date'     => [TireMessages::INVALID_PURCHASE_DATE]
                ]
            ],
            [
                [
                    'brand'             => 'Brand3',
                    'model'             => 'Model3',
                    'size'              => 'Size3',
                    'type'              => 'Type3',
                    'dot'               => '<ps>',
                    'code'              => '<scpt>',
                    'purchase_date'     => '2017-02-29',
                    'purchase_price'    => 17
                ],
                [
                    'dot'               => [TireMessages::INVALID_DOT],
                    'code'              => [TireMessages::INVALID_CODE],
                    'purchase_date'     => [TireMessages::INVALID_PURCHASE_DATE]
                ]
            ],
            [
                [
                    'brand'             => 'Brand4',
                    'model'             => 'Model4',
                    'size'              => 'Size4',
                    'type'              => 'Type4',
                    'dot'               => '4444',
                    'code'              => '666666',
                    'purchase_date'     => '2017-12-31',
                    'purchase_price'    => '17.50'
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
