<?php
declare(strict_types=1);

namespace Api\Validator\Tire;

use PHPUnit\Framework\TestCase;
use Api\Exception\ValidatorException;
use Api\Enum\TireMessages;

class SizeTest extends TestCase
{
    public function additionProvider()
    {
        $testData = [
            [
                ['name' => ''],
                ['name' => [TireMessages::NOT_BLANK]]
            ],
            [
                ['name' => str_pad('A', Size::SIZE_MAX_LEN + 1)],
                ['name' => [sprintf(TireMessages::MORE_THAN, Size::SIZE_MAX_LEN)]]
            ],
            [
                ['name' => 'ABC'],
                ['name' => [sprintf(TireMessages::LESS_THAN, Size::SIZE_MIN_LEN)]]
            ],
            [
                ['name' => '<p><script></script></p>'],
                ['name' => [TireMessages::INVALID_SIZE]]
            ],
            [
                ['name' => 'AB/CD'],
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
        $sizeValidator = new Size();
        $messages = [];

        try {
            $sizeValidator->validate($testData);
        } catch (ValidatorException $exception) {
            $messages = $exception->getMessages();
        }

        $this->assertEquals($expectedData, $messages);
    }
}
