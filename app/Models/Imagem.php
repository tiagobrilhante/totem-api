<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Imagem extends Model
{
    use SoftDeletes;

    protected $fillable = ['ordem', 'nome', 'imagem', 'legenda', 'saibamais', 'banner', 'assunto_id', 'fonte', 'acessos'];


    public function assunto()
    {
        return $this->belongsTo(Assunto::class);

    }

}

