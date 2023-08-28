<?php

namespace App\Http\Resources\Admin;

use App\Models\Answer;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name ?? '',
            'age'        => $this->age ? $this->age->format('d-m-Y') : '',
            'ageNum'     => $this->age ? $this->age->diffForHumans(null, true) : '',
            'email'      => $this->user->email ?? 'ليس لده اسم دخول',
            'details'    => $this->details ?? '',
            'address'    => $this->address ?? '',
            'phone'      => $this->phone ?? '',
            'photo'      => $this->photo ? $this->photo->getUrl('thumbnail') : null,
            'level'      => $this->level[0]->level->name ?? '',
            'level_id'   => $this->level[0]->level->id ?? '',
            // // 'trees'      => new StudentTreeDetailsResource($this->level[0]->level) ?? null,
            // 'trees'      => $this->level[0] ? $this->level[0]->level->materials_all->transform(fn ($e) => [
            //     'id' => $e->id . $e->name,
            //     'label' => " المادة الدراسية :  " . $e->name,
            //     'description' => 'test description',
            //     'name'     => 'test name',
            //     'children' => $e->materials->where('level_id', $this->level[0]->level->id)->transform(fn ($i) => [
            //         'id' => $i->id . $i->teacher->id,
            //         'label' => " اسم المعلم :  " . $i->teacher->name ?? '',
            //         'children'      => $i->tutorials->whereIn('id', Answer::where('user_id', $this->user_id)
            //             ->where('material_id', $e->id)->pluck('tutorial_id'))
            //             ->transform(fn ($i) => [
            //                 'id' => $i->id,
            //                 'label' =>  " عنوان الدرس : " . $i->title,
            //                 'children' => $i->asks->transform(fn ($i) => [
            //                     'id'      => $i->id . $i->ask,
            //                     'label'     => $i->ask,
            //                     'details' => $i->details,
            //                     'children' => $i->answers->transform(fn ($e) => [
            //                         'id' => $e->id . $e->answer,
            //                         'label' => $e->answer,
            //                         'icon' => $e->status == 1 ? 'task_alt' : 'panorama_fish_eye',
            //                     ])
            //                 ]),
            //             ]),

            //     ]) ?? [],
            // ]) : [],
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y') : '',
            'deleted_at' => $this->deleted_at ?? '',
        ];
    }
}
