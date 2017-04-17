<?php
declare(strict_types=1);

namespace Api\Validator\Vehicle;

use PHPUnit\Framework\TestCase;
use Api\Exception\ValidatorException;
use Api\Enum\VehicleMessages;

class TypeTest extends TestCase
{
    public function additionProvider()
    {
        $testData = [
            [
                ['name' => ''],
                ['name' => [VehicleMessages::NOT_BLANK]]
            ],
            [
                ['name' => str_pad('A', Type::TYPE_MAX_LEN + 1)],
                ['name' => [sprintf(VehicleMessages::MORE_THAN, Type::TYPE_MAX_LEN)]]
            ],
            [
                ['name' => '<p><script></script></p>'],
                ['name' => [VehicleMessages::INVALID_TYPE]]
            ],
            [
                ['name' => 'Truck'],
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
        $typeValidator = new Type();
        $messages = [];

        try {
            $typeValidator->validate($testData);
        } catch (ValidatorException $exception) {
            $messages = $exception->getMessages();
        }

        $this->assertEquals($expectedData, $messages);
    }
}
