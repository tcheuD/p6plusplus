<?php

namespace App\Service;

class Pagination
{
    public function paginateComments($page, $comments) {
        $pagination = array(
            'page' => $page,
            'nbPages' => ceil(count($comments) / 5),
            'nomRoute' => 'show_trick',
            'paramsRoute' => array()
        );
        return $pagination;
    }

}
