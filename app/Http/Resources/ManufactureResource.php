<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ManufactureResource extends JsonResource
{
   /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this);
        return[
            'id' =>$this->id,
            'name' =>$this->name,
            'status'=>$this->status,
            'featured'=>1,
            'media' => count($this->media) > 0 ?new MediaResource($this->media()->first()) :null
        ];
    }
}