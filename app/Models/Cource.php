<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cource extends Model
{
    protected $table = 'cources';

protected $fillable = [
    'title',
    'subtitle',
    'description',
    'slug',
    'instructor_id',
    'category',
    'videos',
    'pdfs',
    'thumbnail',
    'duration',
    'price',
    'old_price',
    'language',
    'level',
    'is_free',
    'status',
    'details',
    'requirements',
    'outcomes',
    'tags',
    'published_at',
    'is_featured',
];

    protected $casts = [
        'videos' => 'array',
        'pdfs' => 'array',
    ];
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'subscribes', 'cource_id', 'student_id')->withTimestamps();
    }
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
    public function subscriptions()
{
    return $this->hasMany(Subscribe::class, 'cource_id');
}

}
