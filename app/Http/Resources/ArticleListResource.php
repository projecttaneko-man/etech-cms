<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'title'       => $this->title,
            'slug'        => $this->slug,
            'excerpt'     => $this->excerpt,
            'thumbnail'   => $this->thumbnail ? asset('storage/' . $this->thumbnail) : null,
            'category'    => $this->whenLoaded('category', fn () => [
            'name'        => $this->category->name,
            'slug'        => $this->category->slug,
            ]),
            'author'      => $this->whenLoaded('author', fn () => $this->author->name),
            'views_count' => $this->views_count,
            'published_at'=> optional($this->published_at)->toIso8601String(),
        ];
    }
}