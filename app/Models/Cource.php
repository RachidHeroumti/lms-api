<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cource extends Model
{
    protected $table = 'cources';

    protected $fillable = [
        'title',
        'description',
        'slug',
        'instructor_id',
        'category',
        'videos',
        'pdfs',
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
}
