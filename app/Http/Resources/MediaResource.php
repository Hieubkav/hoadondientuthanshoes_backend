<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;

class MediaResource extends BaseResource
{
    public function toArray($request): array
    {
        $thumbUrl = $this->hasGeneratedConversion('thumb')
            ? $this->getFullUrl('thumb')
            : $this->getFullUrl();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'file_name' => $this->file_name,
            'collection_name' => $this->collection_name,
            'mime_type' => $this->mime_type,
            'size' => $this->size,
            'url' => $this->resolvePublicStorageUrl($this->getFullUrl()),
            'thumbnail_url' => $this->resolvePublicStorageUrl($thumbUrl),
            'custom_properties' => $this->custom_properties,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    private function resolvePublicStorageUrl(string $url): string
    {
        $path = ltrim(parse_url($url, PHP_URL_PATH) ?: '', '/');

        if (! Str::startsWith($path, ['storage/', 'public/storage/'])) {
            return $url;
        }

        $path = Str::startsWith($path, 'storage/')
            ? substr($path, strlen('storage/'))
            : substr($path, strlen('public/storage/'));

        return url('public/storage/'.$path);
    }
}
