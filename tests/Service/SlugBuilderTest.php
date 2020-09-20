<?php

namespace App\Tests\Service;

use App\Service\SlugBuilder;
use PHPUnit\Framework\TestCase;

class SlugBuilderTest extends TestCase
{
    /**
     * @dataProvider titleProvider
     * @param string $title
     * @param string $expected
     */
    public function testBuildSlug(string $title, string $expected): void
    {
        $slugBuilder = new SlugBuilder();

        self::assertSame($expected, $slugBuilder->buildSlug($title));
    }

    public function titleProvider(): array
    {
        return [
            [
                'ONE TWO',
                'one-two'
            ],
            [
                'one  TWO',
                'one--two'
            ],
            [
                'one- TWO',
                'one--two'
            ],
            [
                ' ',
                '-'
            ],
        ];
    }
}
