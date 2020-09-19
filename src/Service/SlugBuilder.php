<?php

namespace App\Service;

class SlugBuilder
{
    public function buildSlug(string $title): string
    {
        return strtolower(str_replace(' ', '-', $title));
    }
}
