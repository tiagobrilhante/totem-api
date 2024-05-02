<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class QuizPergunta extends Model
{
    use SoftDeletes;

    protected $fillable = ['enunciado','enunciado_en','enunciado_es','quiz_id'];


    public function respostas()
    {
        return $this->hasMany(QuizResposta::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);

    }

}

