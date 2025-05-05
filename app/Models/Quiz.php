<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'question',
        'description',
        'option_1',
        'option_2',
        'option_3',
        'option_4',
        'option_5',
        'correct_option',
        'cource_id'
    ];
    public function cource()
    {
        return $this->belongsTo(Cource::class);
    }
}
