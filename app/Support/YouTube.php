<?php

namespace App\Support;

class YouTube
{
    /** Ekstrak ID video dari berbagai format URL YouTube (watch, youtu.be, embed, shorts, live). */
    public static function extractId(?string $url): ?string
    {
        if (blank($url)) {
            return null;
        }

        $pattern = '~(?:youtube(?:-nocookie)?\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/|live/|v/)|youtu\.be/)([A-Za-z0-9_-]{11})~';

        return preg_match($pattern, $url, $m) ? $m[1] : null;
    }

    public static function thumbnail(?string $id): ?string
    {
        return $id ? "https://img.youtube.com/vi/{$id}/hqdefault.jpg" : null;
    }

    public static function embedUrl(?string $id): ?string
    {
        return $id ? "https://www.youtube-nocookie.com/embed/{$id}?rel=0" : null;
    }
}
