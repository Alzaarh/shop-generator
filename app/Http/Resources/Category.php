<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Category extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,

            'title' => $this->title,

            'picture' => $this->picture,

            'details' => $this->details,

            'createdAt' => $this->created_at->toDateTimeString(),

            'updatedAt' => $this->updated_at->toDateTimeString(),

            'parents' => $this->parents(),
        ];

    }
}
