<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Evento extends Model
{
    use SoftDeletes;
    protected $perPage = 6;

    protected $fillable = ['ano','mes','dia', 'nome', 'imagem', 'legenda', 'saibamais','fonteimagempcp', 'acessos'];


    public function imagensAdicionais()
    {

        return $this->hasMany(ImagemEventoAdicional::class);

    }

}

