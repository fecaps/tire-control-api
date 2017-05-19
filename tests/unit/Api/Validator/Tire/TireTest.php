<?php
declare(strict_types=1);

namespace Api\Validator\Tire;

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
                    'brand_id'          => '',
                    'model_id'          => '',
                    'size_id'           => '',
                    'type_id'           => '',
                    'dot'               => '',
                    'code'              => '',
                    'purchase_date'     => '',
                    'purchase_price'    => ''
                ],
                [
                    'brand_id'          => [TireMessages::NOT_BLANK],
                    'model_id'          => [TireMessages::NOT_BLANK],
                    'size_id'           => [TireMessages::NOT_BLANK],
                    'type_id'           => [TireMessages::NOT_BLANK],
                    'dot'               => [TireMessages::NOT_BLANK],
                    'code'              => [TireMessages::NOT_BLANK],
                    'purchase_date'     => [TireMessages::NOT_BLANK],
                    'purchase_price'    => [TireMessages::NOT_BLANK]
                ]
            ],
            [
                [
                    'brand_id'          => 'Brand1',
                    'model_id'          => 'Model1',
                    'size_id'           => 'Size1',
                    'type_id'           => 'Type1',
                    'dot'               => str_pad('A', Tire::DOT_LEN + 1),
                    'code'              => str_pad('A', Tire::CODE_LEN + 1),
                    'purchase_date'     => 20161217,
                    'purchase_price'    => 'It cannot be a text'
                ],
                [
                    'brand_id'          => [TireMessages::INVALID_BRAND],
                    'model_id'          => [TireMessages::INVALID_MODEL],
                    'size_id'           => [TireMessages::INVALID_SIZE],
                    'type_id'           => [TireMessages::INVALID_TYPE],
                    'dot'               => [sprintf(TireMessages::SPECIFIC_LEN, Tire::DOT_LEN)],
                    'code'              => [sprintf(TireMessages::SPECIFIC_LEN, Tire::CODE_LEN)],
                    'purchase_date'     => [TireMessages::INVALID_PURCHASE_DATE],
                    'purchase_price'    => [TireMessages::INVALID_PURCHASE_PRICE]
                ]
            ],
            [
                [
                    'brand_id'          => 1,
                    'model_id'          => 10,
                    'size_id'           => 20,
                    'type_id'           => 30,
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
                    'brand_id'          => 1,
                    'model_id'          => 10,
                    'size_id'           => 20,
                    'type_id'           => 30,
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
                    'brand_id'          => '1',
                    'model_id'          => '10',
                    'size_id'           => '20',
                    'type_id'           => '20',
                    'dot'               => '4444',
                    'code'              => '666666',
                    'purchase_date'     => '2017-12-31',
                    'purchase_price'    => '17.50'
                ],
                [
                    'brand_id'          => [TireMessages::INVALID_BRAND],
                    'model_id'          => [TireMessages::INVALID_MODEL],
                    'size_id'           => [TireMessages::INVALID_SIZE],
                    'type_id'           => [TireMessages::INVALID_TYPE]
                ]
            ],
            [
                [
                    'brand_id'          => 1,
                    'model_id'          => 10,
                    'size_id'           => 20,
                    'type_id'           => 20,
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
