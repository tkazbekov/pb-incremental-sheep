<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SheepResource extends JsonResource
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
            'id'            => (string)$this->id,
            'pen_id'        => (string)$this->pen_id,
        ];
    }
}
