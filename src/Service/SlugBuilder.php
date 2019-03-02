<?php

namespace App\Service;


class SlugBuilder
{
    public function buildSlug($title)
    {
        return strtolower(str_replace(' ', '-', $title));
    }
}
