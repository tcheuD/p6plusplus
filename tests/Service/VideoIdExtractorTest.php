<?php

namespace App\Tests\Service;

use App\Service\VideoIdExtractor;
use PHPUnit\Framework\TestCase;

class VideoIdExtractorTest extends TestCase
{
    /**
     * @dataProvider urlProvider
     * @param string $url
     * @param $expected
     */
    public function testUrlToId(string $url, $expected): void
    {
        $videoIdExtractor = new VideoIdExtractor();

        self::assertSame($expected, $videoIdExtractor->urlToId($url));
    }

    public function urlProvider(): array
    {
        return [
            [
                'http://youtu.be/dQw4w9WgXcQ',
                'dQw4w9WgXcQ'
            ],
            [
                'https://www.youtube.com/watch?v=dQw4w9WgXcQ&feature=youtu.be&ab_channel=RickAstleyVEVO',
                'dQw4w9WgXcQ'
            ],
            [
                'https://youtu.be/dQw4w9WgXcQ?t=76',
                'dQw4w9WgXcQ'
            ],
            [
                'http://localhost:8089',
                false
            ],
            [
                'http://localhost:8089/uzcycezhy',
                false
            ]

        ];
    }
}
