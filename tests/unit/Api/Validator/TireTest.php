<?php
declare(strict_types=1);

namespace Api\Validator;

use PHPUnit\Framework\TestCase;
use Api\Exception\ValidatorException;

class TireTest extends TestCase
{
    public function additionProvider()
    {
        $testData = [
            [
                ['type' => '', 'brand' => '', 'durability' => ''],
                [
                    'type'          => [ValidatorMessages::NOT_BLANK],
                    'brand'         => [ValidatorMessages::NOT_BLANK],
                    'durability'    => [ValidatorMessages::NOT_BLANK],
                    'cost'          => [ValidatorMessages::NOT_BLANK],
                    'situation'     => [ValidatorMessages::NOT_BLANK]
                ]
            ],
            [
                [
                    'type'          => str_pad('A', Tire::TYPE_MAX_LEN + 1),
                    'brand'         => str_pad('A', Tire::BRAND_MAX_LEN + 1),
                    'durability'    => 1000.000,
                    'cost'          => 1000000,
                    'note'          => str_pad('A', Tire::NOTE_MAX_LEN + 1),
                    'situation'     => str_pad('A', Tire::SITUATION_MAX_LEN + 1)
                ],
                [
                    'type'          => [sprintf(ValidatorMessages::MORE_THAN, Tire::TYPE_MAX_LEN)],
                    'brand'         => [sprintf(ValidatorMessages::MORE_THAN, Tire::BRAND_MAX_LEN)],
                    'durability'    => [ValidatorMessages::INVALID_DURABILITY],
                    'cost'          => [ValidatorMessages::INVALID_COST],
                    'note'          => [sprintf(ValidatorMessages::MORE_THAN, Tire::NOTE_MAX_LEN)],
                    'situation'     => [sprintf(ValidatorMessages::MORE_THAN, Tire::SITUATION_MAX_LEN)]
                ]
            ],
            [
                [
                    'type'          => 'Nice Type',
                    'brand'         => 'Nice Brand',
                    'durability'    => 800000,
                    'cost'          => 17.80,
                    'note'          => 'Nice Note',
                    'situation'     => 'Nice Situation'
                ],
                [
                ]
            ],
            [
                [
                    'type'          => '<p><script></script></p>',
                    'brand'         => '<p><script></script></p>',
                    'durability'    => '<p><script>window.location.href="http://example.com";</script></p>',
                    'cost'          => '<p><script>window.location.href="http://example.com";</script></p>',
                    'note'          => '<p><script>alert("You cannot do whatever you want");</script></p>',
                    'situation'     => '<p><script>window.location.href="http://example.com";</script></p>'

                ],
                [
                    'type'          => [ValidatorMessages::INVALID_TYPE],
                    'brand'         => [ValidatorMessages::INVALID_BRAND],
                    'durability'    => [ValidatorMessages::INVALID_DURABILITY],
                    'cost'          => [ValidatorMessages::INVALID_COST],
                    'note'          => [ValidatorMessages::INVALID_NOTE],
                    'situation'     => [ValidatorMessages::INVALID_SITUATION],
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
        $userValidator = new Tire();
        $messages = [];

        try {
            $userValidator->validate($testData);
        } catch (ValidatorException $e) {
            $messages = $e->getMessages();
        }

        $this->assertEquals($expectedData, $messages);
    }
}
