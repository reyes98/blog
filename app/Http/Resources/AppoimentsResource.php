<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class AppoimentsResource extends JsonResource
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
            'email' => $this->email,
            'phone' => $this->phone,
            'start_time' => Carbon::parse($this->start_time)->format('Y-m-d\TH:i'),
            'start_time_formatted' => Carbon::parse($this->start_time)->format('F j, Y, g:i a'),
            'status' => $this->status,
            'price' => $this->price,
            $this->mergeWhen($this->message, function () {
                return [
                    'message' => $this->message,
                    'small_message' => Str::limit(strip_tags($this->message), 80), //limit to 80 character and remove html/php tags
                ];
            }),
            $this->mergeWhen($this->created_at, function () {
                return [
                    'created_at_for_human' => $this->created_at->diffForHumans(),
                    'created_date' => $this->created_at->format('M d, Y'),
                ];
            }),
            $this->mergeWhen($this->updtaed_at, function () {
                return [
                    'updated_at_for_human' => $this->updated_at->diffForHumans(),
                    'updated_date' => $this->updated_at->format('M d, Y'),
                ];
            }),
        ];
    }
}
