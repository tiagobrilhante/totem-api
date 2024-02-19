<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class QuizResposta extends Model
{
    use SoftDeletes;

    protected $fillable = ['resposta','correta','quiz_pergunta_id'];


    public function pergunta()
    {

        return $this->belongsTo(QuizPergunta::class);

    }

}

