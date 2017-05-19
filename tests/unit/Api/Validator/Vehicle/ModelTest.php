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
                    'brand_id'  => '',
                    'model'     => ''
                ],
                [
                    'brand_id'  => [VehicleMessages::NOT_BLANK],
                    'model'     => [VehicleMessages::NOT_BLANK]
                ]
            ],
            [
                [
                    'brand_id'  => '1',
                    'model'     => str_pad('A', Model::MODEL_MAX_LEN + 1)
                ],
                [
                    'brand_id'  => [VehicleMessages::INVALID_BRAND],
                    'model'     => [sprintf(VehicleMessages::MORE_THAN, Model::MODEL_MAX_LEN)]
                ]
            ],
            [
                [
                    'brand_id'  => 1,
                    'model'     => '<p><script></script></p>'
                ],
                [
                    'model'     => [VehicleMessages::INVALID_MODEL]
                ]
            ],
            [
                [
                    'brand_id'  => 1,
                    'model'     => 'Model3'
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
