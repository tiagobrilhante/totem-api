<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class QuizEstatistica extends Model
{
    use SoftDeletes;

    protected $fillable = ['quiz_id', 'score'];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);

    }

}

