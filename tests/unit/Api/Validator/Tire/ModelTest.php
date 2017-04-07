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
                ['model' => ''],
                ['model' => [TireMessages::NOT_BLANK]]
            ],
            [
                ['model' => str_pad('A', Model::MODEL_MAX_LEN + 1)],
                ['model' => [sprintf(TireMessages::MORE_THAN, Model::MODEL_MAX_LEN)]]
            ],
            [
                ['model' => 'ABC'],
                ['model' => [sprintf(TireMessages::LESS_THAN, Model::MODEL_MIN_LEN)]]
            ],
            [
                ['model' => '<p><script></script></p>'],
                ['model' => [TireMessages::INVALID_MODEL]]
            ],
            [
                ['model' => 'FR85'],
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
        } catch (ValidatorException $e) {
            $messages = $e->getMessages();
        }

        $this->assertEquals($expectedData, $messages);
    }
}
