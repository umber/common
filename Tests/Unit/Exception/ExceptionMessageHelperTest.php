<?php

declare(strict_types=1);

namespace Umber\Common\Tests\Unit\Exception;

use Umber\Common\Exception\ExceptionMessageHelper;

use PHPUnit\Framework\TestCase;

/**
 * {@inheritdoc}
 *
 * @covers \Umber\Common\Exception\ExceptionMessageHelper
 */
class ExceptionMessageHelperTest extends TestCase
{
    /**
     * @test
     *
     * @group unit
     * @group exception
     */
    public function canTranslateStringWithoutParameters(): void
    {
        $message = 'string';

        $output = ExceptionMessageHelper::translate($message);

        $expected = 'string';

        self::assertEquals($expected, $output);
    }

    /**
     * @test
     *
     * @group unit
     * @group exception
     */
    public function canTranslateStringWithUnusedParameters(): void
    {
        $message = 'string';

        $output = ExceptionMessageHelper::translate($message, [
            'string' => 'something',
        ]);

        $expected = 'string';

        self::assertEquals($expected, $output);
    }

    /**
     * @test
     *
     * @group unit
     * @group exception
     */
    public function canTranslateStringWithParameters(): void
    {
        $message = 'string {{world}}';

        $output = ExceptionMessageHelper::translate($message, [
            'world' => 'hello',
        ]);

        $expected = 'string hello';

        self::assertEquals($expected, $output);
    }

    /**
     * @test
     *
     * @group unit
     * @group exception
     */
    public function canTranslateArrayWithoutParameters(): void
    {
        $message = [
            'string',
        ];

        $output = ExceptionMessageHelper::translate($message);

        $expected = 'string';

        self::assertEquals($expected, $output);
    }

    /**
     * @test
     *
     * @group unit
     * @group exception
     */
    public function canTranslateArrayMultipleWithoutParameters(): void
    {
        $message = [
            'string',
            'string',
            'another',
        ];

        $output = ExceptionMessageHelper::translate($message);

        $expected = 'string string another';

        self::assertEquals($expected, $output);
    }

    /**
     * @test
     *
     * @group unit
     * @group exception
     */
    public function canTranslateArrayWithParameters(): void
    {
        $message = [
            'string',
            'string {{world}}',
            '{{world}}',
        ];

        $output = ExceptionMessageHelper::translate($message, [
            'world' => 'hello',
        ]);

        $expected = 'string string hello hello';

        self::assertEquals($expected, $output);
    }

    /**
     * @test
     *
     * @group unit
     * @group exception
     */
    public function canReplaceEmptyStringWithinParameters(): void
    {
        $message = [
            'string',
            'string {{world}}',
            '{{world}}',
        ];

        $output = ExceptionMessageHelper::translate($message, [
            'world' => '',
        ]);

        $expected = 'string string {empty-string} {empty-string}';

        self::assertEquals($expected, $output);
    }
}
