<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MarkdownPostApiResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'excerpt' => $this->excerpt->__toString(),
            'tags' => $this->tags,
            'list_image' => $this->list_image,
            'slug' => $this->slug,
            'link' => $this->getLink()
        ];
    }
}
