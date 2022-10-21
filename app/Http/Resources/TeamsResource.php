<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeamsResource extends JsonResource
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
            'id' => (string)$this->id,
            'atributes' => [
                'name' => (string)$this->name,
                'body' => (string)$this->body,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'relations' => [
                'user id' => (string)$this->user->id,
                'user name' => (string)$this->user->name,
                'user email' => (string)$this->user->email,
            ]
        ];
    }
}
