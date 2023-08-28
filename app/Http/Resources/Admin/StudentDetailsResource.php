<?php

namespace App\Http\Resources\Admin;

use App\Models\Answer;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentDetailsResource extends JsonResource
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
            'levelName'  => $this->level[0]->level->name ?? '',
            'levelClass'      => $this->level[0] ? $this->level[0]->level->materials_all->transform(fn ($e) => [
                'id' => $e->id,
                'name' => $e->name,
                // 'teacher' => $e->teachers->transform(fn ($i) => $i->name) ?? [],
                'materials' => $e->materials->where('level_id', $this->level[0]->level->id)->transform(fn ($i) => [
                    'id' => $i->id,
                    'teacher' => $i->teacher->name ?? '',
                    'tutorials' => $i->tutorials->count(),
                    'tutorialCount' => $i->tutorials->whereNotIn('id', Answer::where('user_id', $this->user_id)
                        ->where('material_id', $e->id)->pluck('tutorial_id'))
                        ->count(),
                    'data'      => $i->tutorials->whereNotIn('id', Answer::where('user_id', $this->user_id)
                        ->where('material_id', $e->id)->pluck('tutorial_id'))
                        ->first(),
                    'answers'   => $i->tutorials->transform(
                        fn ($a) =>
                        [
                            'askAll' => $a->answers->where('user_id', $this->user_id)->count(),
                            'askTrue' => $a->answers->where('user_id', $this->user_id)->where('status', 1)->count(),
                            'askFalse' => $a->answers->where('user_id', $this->user_id)->where('status', 0)->count(),
                        ]
                    ),


                    // 'answers_al'   => $i->tutorials->transform(fn ($e) => $e->answers->count()),
                    // 'answers_a'   => $i->tutorials->transform(fn ($i) => $i->answers),
                    // 'answers_true'   => $i->tutorials->transform(fn ($e) => $e->answersTrue->count()),
                    // 'materials' => $i->materials->count(),
                ]) ?? [],
                // 'levels' => $e->levels->transform(fn ($i) => $i) ?? [],

                // 'data' => $e
            ]) : '',
            // 'level'      => $this->level->transform(fn ($e) => [
            //     'id'     => $e->id,
            //     'level'  => $e->level,
            //     'materials' => $e->level->materials->transform(fn ($i) => [
            //         'id' => $i
            //     ])
            // ]) ?? '',
            'level_id'   => $this->level[0]->level->id ?? '',
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y') : '',
            'deleted_at' => $this->deleted_at ?? '',
        ];
    }
}
