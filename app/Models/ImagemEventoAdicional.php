<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ImagemEventoAdicional extends Model
{
    use SoftDeletes;

    protected $fillable = ['imagem', 'descricao','descricao_en','descricao_es', 'fonte',  'evento_id'];

    public function evento()
    {

        return $this->belongsTo(Evento::class);

    }

}

