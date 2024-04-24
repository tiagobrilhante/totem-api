<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Imagem extends Model
{
    use SoftDeletes;

    protected $fillable = ['ordem', 'nome','nome_en','nome_es', 'imagem', 'legenda','legenda_en','legenda_es', 'saibamais','saibamais_en', 'saibamais_es', 'banner', 'assunto_id', 'fonte', 'acessos'];


    public function assunto()
    {
        return $this->belongsTo(Assunto::class);

    }

}

