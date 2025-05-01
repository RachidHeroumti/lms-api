<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cource extends Model
{
    // Specify the table name if it's not plural 'cources'
    protected $table = 'cources';

    // Define which fields are mass assignable
    protected $fillable = [
        'title',
        'description',
        'instructor',
        'category',
        'video_url',
        'pdf_url',
    ];

    // Optionally define relationships (e.g., with a User model for instructors)
    // If you have an 'instructor' as a reference to a User model
    // public function instructor()
    // {
    //     return $this->belongsTo(User::class);
    // }

    // If you want to retrieve files like video_url and pdf_url, they are just attributes here.
}
