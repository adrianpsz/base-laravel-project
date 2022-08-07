<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'message' => nl2br($this->message),
            'active' => $this->is_active,
            'created_at' => $this->created_at->format('Y-m-d'),
            'images' => ImageResource::collection($this->images),
            'user' => new UserResource($this->user),
        ];
    }
}
