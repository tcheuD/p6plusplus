<?php

namespace App\Tests\Service;

use App\Service\Pagination;
use PHPUnit\Framework\TestCase;

class PaginationTest extends TestCase
{

    public function testPaginateComments(): void
    {
        $pagination = new Pagination();

        $comments = array_fill(0, 35, 'comment');
        $page = 2;

        $expectedPagination = [
            'page' => $page,
            'nbPages' => ceil(count($comments) / 5 ),
            'nomRoute' => 'show_trick',
            'paramsRoute' => []
        ];

        self::assertSame($expectedPagination, $pagination->paginateComments($page, $comments));

    }
}
