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
                [
                    'brand' => '',
                    'model' => ''
                ],
                [
                    'brand' => [VehicleMessages::NOT_BLANK],
                    'model' => [VehicleMessages::NOT_BLANK]
                ]
            ],
            [
                [
                    'brand' => 'Brand1',
                    'model' => str_pad('A', Model::MODEL_MAX_LEN + 1)
                ],
                [
                    'model' => [sprintf(VehicleMessages::MORE_THAN, Model::MODEL_MAX_LEN)]
                ]
            ],
            [
                [
                    'brand' => 'Brand2',
                    'model' => '<p><script></script></p>'
                ],
                [
                    'model' => [VehicleMessages::INVALID_MODEL]
                ]
            ],
            [
                [
                    'brand' => 'Brand3',
                    'model' => 'Model3'
                ],
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
