<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CreateMaterialResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'level' => $this->level->name ?? '',
            'material' => $this->material->name ?? '',
            'teacher' => $this->teacher->name ?? '',
        ];
    }
}
