<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Quiz extends Model
{
    use SoftDeletes;

    protected $fillable = ['cabecalho','maxscore','ativo'];


    public function perguntas()
    {
        return $this->hasMany(QuizPergunta::class);
    }

    public function estatisticas()
    {
        return $this->hasMany(QuizEstatistica::class);
    }

}

