<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->when($this->slug, $this->slug),//extract value if field present
            'created_at_for_human' => $this->when($this->created_at, function () { //extract the key only if present
                return $this->created_at->diffForHumans();
            }),
        ];
    }
}
