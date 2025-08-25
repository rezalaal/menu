<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // فرض: کالکشن پیش‌فرض تصاویر است و برای ویدئو کالکشن 'videos' دارید
        $imageUrl = $this->getFirstMediaUrl() ?: url('/images/table.jpg');
        $videoUrl = $this->getFirstMediaUrl('videos') ?: url(path: '/videos/coral.mp4');

        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'called_waiter' => (bool) $this->called_waiter,
            'image_url'     => $imageUrl,
            'video_url'     => $videoUrl,
        ];
    }
}
