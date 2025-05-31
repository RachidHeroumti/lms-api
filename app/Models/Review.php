<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'course_id', 'user_id'];

    public function course()
    {
        return $this->belongsTo(Cource::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

