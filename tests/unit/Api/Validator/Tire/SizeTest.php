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
                ['size' => ''],
                ['size' => [TireMessages::NOT_BLANK]]
            ],
            [
                ['size' => str_pad('A', Size::SIZE_MAX_LEN + 1)],
                ['size' => [sprintf(TireMessages::MORE_THAN, Size::SIZE_MAX_LEN)]]
            ],
            [
                ['size' => 'ABC'],
                ['size' => [sprintf(TireMessages::LESS_THAN, Size::SIZE_MIN_LEN)]]
            ],
            [
                ['size' => '<p><script></script></p>'],
                ['size' => [TireMessages::INVALID_SIZE]]
            ],
            [
                ['size' => 'AB/CD'],
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
        } catch (ValidatorException $e) {
            $messages = $e->getMessages();
        }

        $this->assertEquals($expectedData, $messages);
    }
}
