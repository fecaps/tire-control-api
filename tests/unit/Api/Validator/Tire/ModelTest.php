<?php
declare(strict_types=1);

namespace Api\Validator\Tire;

use PHPUnit\Framework\TestCase;
use Api\Exception\ValidatorException;
use Api\Enum\TireMessages;

class ModelTest extends TestCase
{
    public function additionProvider()
    {
        $testData = [
            [
                ['name' => ''],
                ['name' => [TireMessages::NOT_BLANK]]
            ],
            [
                ['name' => str_pad('A', Model::MODEL_MAX_LEN + 1)],
                ['name' => [sprintf(TireMessages::MORE_THAN, Model::MODEL_MAX_LEN)]]
            ],
            [
                ['name' => 'ABC'],
                ['name' => [sprintf(TireMessages::LESS_THAN, Model::MODEL_MIN_LEN)]]
            ],
            [
                ['name' => '<p><script></script></p>'],
                ['name' => [TireMessages::INVALID_MODEL]]
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
