<?php
declare(strict_types=1);

namespace Api\Validator\Vehicle;

use PHPUnit\Framework\TestCase;
use Api\Exception\ValidatorException;
use Api\Enum\VehicleMessages;

class BrandTest extends TestCase
{
    public function additionProvider()
    {
        $testData = [
            [
                ['name' => ''],
                ['name' => [VehicleMessages::NOT_BLANK]]
            ],
            [
                ['name' => str_pad('A', Brand::BRAND_MAX_LEN + 1)],
                ['name' => [sprintf(VehicleMessages::MORE_THAN, Brand::BRAND_MAX_LEN)]]
            ],
            [
                ['name' => '<p><script></script></p>'],
                ['name' => [VehicleMessages::INVALID_BRAND]]
            ],
            [
                ['name' => 'VW'],
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
