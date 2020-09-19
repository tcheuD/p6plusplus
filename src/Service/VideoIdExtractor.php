<?php

namespace App\Service;

class VideoIdExtractor
{
    /**
     * @param string $url
     * @return false|string
     */
    public function urlToId(string $url)
    {
        $pregMatch = preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',
            $url, $match);

        return $pregMatch ? $match[1] : false;
    }

}
