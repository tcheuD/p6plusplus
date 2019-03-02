<?php

namespace App\Service;

class VideoIdExtractor
{
    public function urlToId($url)
    {

        $pregMatch = preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',
            $url, $match);

        if ($pregMatch)
        {
            return $match[1];
        }

        return false;
    }

}
