<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'title'             => $this->title,
            'slug'              => $this->slug,
            'excerpt'           => $this->excerpt,
            'content'           => $this->content,
            'thumbnail'         => $this->thumbnail ? asset('storage/' . $this->thumbnail) : null,
            'category'          => $this->whenLoaded('category', fn () => [
                'name' => $this->category->name,
                'slug' => $this->category->slug,
            ]),
            'author'            => $this->whenLoaded('author', fn () => $this->author->name),
            'meta_title'        => $this->meta_title,
            'meta_description'  => $this->meta_description,
            'meta_keywords'     => $this->meta_keywords,
            'views_count'       => $this->views_count,
            'published_at'      => optional($this->published_at)->toIso8601String(),
            'status' => $this->status,
        ];
    }
}