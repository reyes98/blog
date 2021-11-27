<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingsResource extends JsonResource
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
            'hero_description' => $this->heroDescription(),
            'hero_image_url' => $this->imageUrl('data->hero_image'),
            'about_description' => $this->aboutDescription(),
            'about_image_url' => $this->imageUrl('data->about_image'),
            'contact_image_url' => $this->imageUrl('data->contact_image'),
            'contact_formal_image_url' => $this->imageUrl('data->contact_formal_image'),
            'contact_description' => $this->contactDescription(),
            'google_map_url' => $this->googleMapUrl(),
            'address' => $this->address(),
            'email' => $this->email(),
            'phone' => $this->phone(),
        ];
    }
}
