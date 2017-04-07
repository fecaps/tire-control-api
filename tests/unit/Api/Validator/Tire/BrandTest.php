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
                ['name' => ''],
                ['name' => [TireMessages::NOT_BLANK]]
            ],
            [
                ['name' => str_pad('A', Brand::BRAND_MAX_LEN + 1)],
                ['name' => [sprintf(TireMessages::MORE_THAN, Brand::BRAND_MAX_LEN)]]
            ],
            [
                ['name' => 'ABC'],
                ['name' => [sprintf(TireMessages::LESS_THAN, Brand::BRAND_MIN_LEN)]]
            ],
            [
                ['name' => '<p><script></script></p>'],
                ['name' => [TireMessages::INVALID_BRAND]]
            ],
            [
                ['name' => 'Pirelli'],
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
        } catch (ValidatorException $exception) {
            $messages = $exception->getMessages();
        }

        $this->assertEquals($expectedData, $messages);
    }
}
