<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MonsterResource extends JsonResource
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
            'name' => $this->name,
            'life' => $this->life,
            'hunger' => $this->hunger,
            'energy' => $this->energy,
            'sleeping' => boolval($this->sleeping),
            'dead' => boolval($this->dead),
            'gender' => $this->gender,
            'race' => $this->race,
            'size' => $this->size,
            'favorite_color' => $this->favorite_color,
            'user' => [
                'name' => $this->user->name,
                'username' => $this->user->username,
            ]
        ];
    }
}
