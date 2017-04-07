<?php
declare(strict_types=1);

namespace Api\Validator\Tire;

use PHPUnit\Framework\TestCase;
use Api\Exception\ValidatorException;
use Api\Enum\TireMessages;

class BrandTest extends TestCase
{
    public function additionProvider()
    {
        $testData = [
            [
                ['brand' => ''],
                ['brand' => [TireMessages::NOT_BLANK]]
            ],
            [
                ['brand' => str_pad('A', Size::SIZE_MAX_LEN + 1)],
                ['brand' => [sprintf(TireMessages::MORE_THAN, Brand::BRAND_MAX_LEN)]]
            ],
            [
                ['brand' => 'ABC'],
                ['brand' => [sprintf(TireMessages::LESS_THAN, Brand::BRAND_MIN_LEN)]]
            ],
            [
                ['brand' => '<p><script></script></p>'],
                ['brand' => [TireMessages::INVALID_BRAND]]
            ],
            [
                ['brand' => 'Pirelli'],
                []
            ]
        ];

        return $testData;
    }

    /**
     * @dataProvider additionProvider
     */
    public function testShouldThrowValidatorExceptionOnInvalidaData($testData, $expectedData)
    {
        $brandValidator = new Brand();
        $messages = [];

        try {
            $brandValidator->validate($testData);
        } catch (ValidatorException $e) {
            $messages = $e->getMessages();
        }

        $this->assertEquals($expectedData, $messages);
    }
}
