<?php
declare(strict_types=1);

namespace Api\Validator\Tire;

use PHPUnit\Framework\TestCase;
use Api\Exception\ValidatorException;
use Api\Enum\TireMessages;

class TypeTest extends TestCase
{
    public function additionProvider()
    {
        $testData = [
            [
                ['name' => ''],
                ['name' => [TireMessages::NOT_BLANK]]
            ],
            [
                ['name' => str_pad('A', Type::TYPE_MAX_LEN + 1)],
                ['name' => [sprintf(TireMessages::MORE_THAN, Type::TYPE_MAX_LEN)]]
            ],
            [
                ['name' => 'ABC'],
                ['name' => [sprintf(TireMessages::LESS_THAN, Type::TYPE_MIN_LEN)]]
            ],
            [
                ['name' => '<p><script></script></p>'],
                ['name' => [TireMessages::INVALID_TYPE]]
            ],
            [
                ['name' => 'FR85'],
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
