<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    protected $fillable = [
        'address', 'phone', 'whatsapp', 'email', 'maps_embed_url',
        'instagram', 'facebook', 'youtube', 'tiktok',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate([]);
    }

    /** Link wa.me dari nomor WhatsApp (menerima 08xx, +62xx, atau 62xx). */
    public function getWhatsappUrlAttribute(): ?string
    {
        $number = preg_replace('/\D+/', '', (string) $this->whatsapp);

        if ($number === '') {
            return null;
        }

        if (str_starts_with($number, '0')) {
            $number = '62'.substr($number, 1);
        }

        return "https://wa.me/{$number}";
    }

    /** URL embed peta hanya diterima dari domain Google Maps via HTTPS. */
    public function getSafeMapsUrlAttribute(): ?string
    {
        $url = (string) $this->maps_embed_url;
        $host = parse_url($url, PHP_URL_HOST);

        return parse_url($url, PHP_URL_SCHEME) === 'https'
            && in_array($host, ['www.google.com', 'google.com', 'maps.google.com'], true)
            ? $url
            : null;
    }

    public function getTelUrlAttribute(): ?string
    {
        $number = preg_replace('/[^\d+]/', '', (string) $this->phone);

        return $number ? 'tel:'.$number : null;
    }

    /** @return array<int, array{key:string,label:string,url:string}> */
    public function getSocialLinksAttribute(): array
    {
        $links = [];

        foreach (['instagram' => 'Instagram', 'facebook' => 'Facebook', 'youtube' => 'YouTube', 'tiktok' => 'TikTok'] as $key => $label) {
            $url = (string) $this->{$key};

            if (preg_match('~^https?://~i', $url)) {
                $links[] = ['key' => $key, 'label' => $label, 'url' => $url];
            }
        }

        return $links;
    }
}
