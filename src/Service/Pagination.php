<?php

namespace App\Service;

class Pagination
{
    public function paginateComments($page, $comments): array
    {
        return [
            'page' => $page,
            'nbPages' => ceil(count($comments) / 5),
            'nomRoute' => 'show_trick',
            'paramsRoute' => []
        ];
    }
}
