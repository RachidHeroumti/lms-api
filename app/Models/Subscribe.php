<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscribe extends Model
{
    protected $table = 'subscribes';

    protected $fillable = [
        'cource_id',
        'student_id',
        'price',
        'accepted'
    ];
 public function student(): BelongsTo
 {
     return $this->belongsTo(User::class, 'student_id');
 }

 public function cource(): BelongsTo
 {
     return $this->belongsTo(Cource::class, 'cource_id');
 }
}
