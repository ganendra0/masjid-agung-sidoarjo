<?php

namespace App\Support;

use Illuminate\Support\Str;

class Text
{
    /** Ubah HTML rich text menjadi teks polos (spasi antar paragraf dijaga), opsional dipotong. */
    public static function plain(?string $html, int $limit = 0): string
    {
        $text = (string) Str::of((string) $html)
            ->replaceMatches('~</(p|li|div|h[1-6]|br)>|<br\s*/?>~i', '$0 ')
            ->stripTags()
            ->squish();

        return $limit > 0 ? Str::limit($text, $limit) : $text;
    }
}
