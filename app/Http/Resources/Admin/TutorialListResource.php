<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class TutorialListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'title'      => $this->title ?? '',
            'material'   => $this->material ? $this->material->material->name : '',
            'level'      => $this->material ? $this->material->level->name : '',
            'teacher'    => $this->material ? $this->material->teacher->name : '',
            'user'       => $this->user->name ?? '',
            'answers'       => $this->asks->transform(fn ($i) => [
                'id'      => $i->id,
                'ask'     => $i->ask,
                'details' => $i->details,
                'answers' => $i->answers->transform(fn ($e) => ['id' => $e->id,'answer' => $e->answer, 'status' => $e->status])
            ]),
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y') : '',
            'deleted_at' => $this->deleted_at ?? '',
        ];
    }
}
