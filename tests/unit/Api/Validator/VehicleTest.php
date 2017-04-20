<?php
declare(strict_types=1);

namespace Api\Validator;

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
                    'type'      => '',
                    'brand'     => '',
                    'model'     => '',
                    'category'  => '',
                    'plate'     => ''
                ],
                [
                    'type'      => [VehicleMessages::NOT_BLANK],
                    'brand'     => [VehicleMessages::NOT_BLANK],
                    'model'     => [VehicleMessages::NOT_BLANK],
                    'category'  => [VehicleMessages::NOT_BLANK],
                    'plate'     => [VehicleMessages::NOT_BLANK]
                ]
            ],
            [
                [
                    'type'      => 'Type2',
                    'brand'     => 'Brand2',
                    'model'     => 'Model2',
                    'category'  => 'Category2',
                    'plate'     => '<>@Ç/>'
                ],
                [
                    'plate'     => [VehicleMessages::INVALID_PLATE]
                ]
            ],
            [
                [
                    'type'      => 'Type3',
                    'brand'     => 'Brand3',
                    'model'     => 'Model3',
                    'category'  => 'Category3',
                    'plate'     => str_pad('A', Vehicle::PLATE_LEN + 1)
                ],
                [
                    'plate'     => [sprintf(VehicleMessages::SPECIFIC_LEN, Vehicle::PLATE_LEN)]
                ]
            ],
            [
                [
                    'type'      => 'Type4',
                    'brand'     => 'Brand4',
                    'model'     => 'Model4',
                    'category'  => 'Category4',
                    'plate'     => '678678'
                ],
                [
                    'plate'     => [VehicleMessages::INVALID_PLATE]
                ]
            ],
            [
                [
                    'type'      => 'Type4',
                    'brand'     => 'Brand4',
                    'model'     => 'Model4',
                    'category'  => 'Category4',
                    'plate'     => '678PLT'
                ],
                [
                    'plate'     => [VehicleMessages::INVALID_PLATE]
                ]
            ],
            [
                [
                    'type'      => 'Type4',
                    'brand'     => 'Brand4',
                    'model'     => 'Model4',
                    'category'  => 'Category4',
                    'plate'     => 'PLT678'
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
