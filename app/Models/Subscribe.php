<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscribe extends Model
{
    //

    protected $table = 'subscribes';

    protected $fillable = [
        'cource_id',
        'student_id',
        'price',
    ];
    
 // Each subscription belongs to a student (user)
 public function student(): BelongsTo
 {
     return $this->belongsTo(User::class, 'student_id');
 }

 // Each subscription belongs to a course
 public function cource(): BelongsTo
 {
     return $this->belongsTo(Cource::class, 'cource_id');
 }
}
