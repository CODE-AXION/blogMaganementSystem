<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => \Str::limit($this->name,50),
            'description' => $this->description,
            'image' => $this->image,
            'created_at' => $this->created_at->format('M j, Y g:i A'),
            'updated_at' => $this->updated_at->format('M j, Y g:i A'),
            'likes_count' => $this->likes_count,
        ];
    }
}
