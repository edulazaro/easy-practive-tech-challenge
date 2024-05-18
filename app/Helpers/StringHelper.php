<?php

namespace App\Helpers;

class StringHelper
{
    /**
     * Generates an excerpt from the given text.
     *
     * @param string $content The original text.
     * @param int $maxLength The maximum length of the excerpt.
     * @return string
     */
    public static function getExcerpt($content, $maxLength = 255)
    {
        if (strlen($content) <= $maxLength) {
            return $content;
        }

        $excerpt = substr($content, 0, $maxLength);
        $lastSpace = strrpos($excerpt, ' ');
        $excerpt = substr($excerpt, 0, $lastSpace);
        $excerpt .= '...';

        return $excerpt;
    }
}
