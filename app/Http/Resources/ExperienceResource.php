<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ExperienceResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->when($this->slug, $this->slug), //extract value if field present
            'category_id' => $this->when($this->category_id, $this->category_id),

            $this->mergeWhen($this->description, function () {
                return [
                    'description' => $this->description,
                    'small_description' => Str::limit(strip_tags($this->description), 80), //limit to 80 character and remove html/php tags
                ];
            }),

            'image_url' => $this->imageUrl(),
            $this->mergeWhen($this->created_at, function () {
                return [
                    'created_at_for_human' => $this->created_at->diffForHumans(),
                    'created_date' => $this->created_at->format('M d, Y'),
                ];
            }),
            'category' => new CategoryResource($this->whenLoaded('category')), //gets the key if requested
        ];
    }
}
