<?php
declare(strict_types=1);

namespace Api\Validator\Vehicle;

use PHPUnit\Framework\TestCase;
use Api\Exception\ValidatorException;
use Api\Enum\VehicleMessages;

class ModelTest extends TestCase
{
    public function additionProvider()
    {
        $testData = [
            [
                ['name' => ''],
                ['name' => [VehicleMessages::NOT_BLANK]]
            ],
            [
                ['name' => str_pad('A', Model::MODEL_MAX_LEN + 1)],
                ['name' => [sprintf(VehicleMessages::MORE_THAN, Model::MODEL_MAX_LEN)]]
            ],
            [
                ['name' => '<p><script></script></p>'],
                ['name' => [VehicleMessages::INVALID_MODEL]]
            ],
            [
                ['name' => '19.320'],
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
        $modelValidator = new Model();
        $messages = [];

        try {
            $modelValidator->validate($testData);
        } catch (ValidatorException $exception) {
            $messages = $exception->getMessages();
        }

        $this->assertEquals($expectedData, $messages);
    }
}
