<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;

class InvoiceResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'seller_tax_code' => $this->seller_tax_code,
            'invoice_code' => $this->invoice_code,
            'image' => $this->image,
            'image_url' => $this->resolveImageUrl(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * Trả về URL hợp lệ cho ảnh hóa đơn, tránh nhân đôi prefix /storage hoặc domain.
     */
    private function resolveImageUrl(): ?string
    {
        if (!$this->image) {
            return null;
        }

        $image = ltrim($this->image, '/');

        // Nếu đã là absolute URL cùng backend cPanel thì chuẩn hóa sang public/storage.
        if (Str::startsWith($image, ['http://', 'https://'])) {
            return $this->resolveAbsoluteImageUrl($image);
        }

        // Nếu lỡ lưu kèm 'storage/' thì bỏ đi để Storage::url không thêm lần nữa.
        if (Str::startsWith($image, 'storage/')) {
            $image = substr($image, strlen('storage/'));
        }

        if (Str::startsWith($image, 'public/storage/')) {
            $image = substr($image, strlen('public/storage/'));
        }

        return url('public/storage/'.$image);
    }

    private function resolveAbsoluteImageUrl(string $image): string
    {
        $url = parse_url($image);
        $path = ltrim($url['path'] ?? '', '/');

        if (! Str::startsWith($path, ['storage/', 'public/storage/'])) {
            return $image;
        }

        $path = Str::startsWith($path, 'storage/')
            ? substr($path, strlen('storage/'))
            : substr($path, strlen('public/storage/'));

        return url('public/storage/'.$path);
    }
}
