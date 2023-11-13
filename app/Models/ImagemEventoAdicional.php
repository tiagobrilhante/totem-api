<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ImagemEventoAdicional extends Model
{
    use SoftDeletes;

    protected $fillable = ['imagem', 'descricao', 'fonte',  'evento_id'];

    public function evento()
    {

        return $this->belongsTo(Evento::class);

    }

}

