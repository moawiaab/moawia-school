<?php

namespace App\Models;

use App\Support\HasAdvancedFilter;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Tutorial extends Model implements HasMedia
{
    use HasAdvancedFilter;
    use SoftDeletes;
    use HasFactory;
    use InteractsWithMedia;
    use HasUuids;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $orderable = [
        'id',
        'title',
        'details',
    ];

    protected $filterable = [
        'id',
        'title',
        'details',
    ];

    protected $fillable = [
        'title',
        'details',
        'url',
        'user_id',
        'material_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }



    public function material()
    {
        return $this->belongsTo(TeacherMaterialLevel::class, 'material_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function asks() {
        return $this->hasMany(TestModel::class, 'tutorial_id');
    }

    public function answers() {
        return $this->hasMany(Answer::class, 'tutorial_id');
    }

    public function answersTrue() {
        return $this->hasMany(Answer::class, 'tutorial_id')->where('status', 1);
    }

    public function answersFalse() {
        return $this->hasMany(Answer::class, 'tutorial_id')->where('status', 0);
    }

    public function getAudiosAttribute()
    {
        return $this->getFirstMedia('tutorial_audio') ?? null;

        // return $this->getMedia('tutorial_audio')->map(function ($item) {
        //     // $media = $item->toArray();
        //     return $item->disk . '/' . $item->id . '/' . $item->file_name;
        // });
    }


}
