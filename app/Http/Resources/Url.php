<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Url extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) : array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'alias' => $this->alias,
            'redirect_url' => $this->redirect_url,
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
