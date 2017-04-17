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
                    'category'  => '<p><script>window.location.href="http://example.com";</script></p>',
                    'plate'     => '<p><script>window.location.href="http://example.com";</script></p>'
                ],
                [
                    'category'  => [VehicleMessages::INVALID_CATEGORY],
                    'plate'     => [VehicleMessages::INVALID_PLATE]
                ]
            ],
            [
                [
                    'type'      => 'Type4',
                    'brand'     => 'Brand4',
                    'model'     => 'Model4',
                    'category'  => 'Category4',
                    'plate'     => 'PLATE678'
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
