<?php
declare(strict_types=1);

namespace Api\Validator\Vehicle;

use PHPUnit\Framework\TestCase;
use Api\Exception\ValidatorException;
use Api\Enum\VehicleMessages;

class VehicleTest extends TestCase
{
    public function additionProvider()
    {
        $testData = [
            [
                [
                    'brand_id'      => '',
                    'category_id'   => '',
                    'model_id'      => '',
                    'type_id'       => '',
                    'plate'         => ''
                ],
                [
                    'brand_id'      => [VehicleMessages::NOT_BLANK],
                    'category_id'   => [VehicleMessages::NOT_BLANK],
                    'model_id'      => [VehicleMessages::NOT_BLANK],
                    'type_id'       => [VehicleMessages::NOT_BLANK],
                    'plate'         => [VehicleMessages::NOT_BLANK]
                ]
            ],
            [
                [
                    'brand_id'      => 'Brand2',
                    'category_id'   => 'Category2',
                    'model_id'      => 'Model2',
                    'type_id'       => 'Type2',
                    'plate'         => '<>@Ç/>'
                ],
                [
                    'brand_id'      => [VehicleMessages::INVALID_BRAND],
                    'category_id'   => [VehicleMessages::INVALID_CATEGORY],
                    'model_id'      => [VehicleMessages::INVALID_MODEL],
                    'type_id'       => [VehicleMessages::INVALID_TYPE],
                    'plate'         => [VehicleMessages::INVALID_PLATE]
                ]
            ],
            [
                [
                    'brand_id'      => 1,
                    'category_id'   => 10,
                    'model_id'      => 20,
                    'type_id'       => 30,
                    'plate'         => str_pad('A', Vehicle::PLATE_LEN + 1)
                ],
                [
                    'plate'     => [sprintf(VehicleMessages::SPECIFIC_LEN, Vehicle::PLATE_LEN)]
                ]
            ],
            [
                [
                    'brand_id'      => '1',
                    'category_id'   => '10',
                    'model_id'      => '20',
                    'type_id'       => '20',
                    'plate'         => '678678'
                ],
                [
                    'brand_id'      => [VehicleMessages::INVALID_BRAND],
                    'category_id'   => [VehicleMessages::INVALID_CATEGORY],
                    'model_id'      => [VehicleMessages::INVALID_MODEL],
                    'type_id'       => [VehicleMessages::INVALID_TYPE],
                    'plate'         => [VehicleMessages::INVALID_PLATE]
                ]
            ],
            [
                [
                    'brand_id'      => 1,
                    'category_id'   => 10,
                    'model_id'      => 20,
                    'type_id'       => 30,
                    'plate'         => '678PLT'
                ],
                [
                    'plate'     => [VehicleMessages::INVALID_PLATE]
                ]
            ],
            [
                [
                    'brand_id'      => 1,
                    'category_id'   => 10,
                    'model_id'      => 20,
                    'type_id'       => 30,
                    'plate'         => 'PLT678'
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
        $vehicleValidator = new Vehicle();
        $messages = [];

        try {
            $vehicleValidator->validate($testData);
        } catch (ValidatorException $exception) {
            $messages = $exception->getMessages();
        }

        $this->assertEquals($expectedData, $messages);
    }
}
