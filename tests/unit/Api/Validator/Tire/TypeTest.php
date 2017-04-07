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
                ['type' => ''],
                ['type' => [TireMessages::NOT_BLANK]]
            ],
            [
                ['type' => str_pad('A', Type::TYPE_MAX_LEN + 1)],
                ['type' => [sprintf(TireMessages::MORE_THAN, Type::TYPE_MAX_LEN)]]
            ],
            [
                ['type' => 'ABC'],
                ['type' => [sprintf(TireMessages::LESS_THAN, Type::TYPE_MIN_LEN)]]
            ],
            [
                ['type' => '<p><script></script></p>'],
                ['type' => [TireMessages::INVALID_TYPE]]
            ],
            [
                ['type' => 'FR85'],
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
        } catch (ValidatorException $e) {
            $messages = $e->getMessages();
        }

        $this->assertEquals($expectedData, $messages);
    }
}
