<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Assunto extends Model
{
    use SoftDeletes;

    protected $fillable = ['nome_assunto', 'nome_assunto_en','nome_assunto_es', 'ordem_exibicao', 'acessos'];

    protected $perPage = 6;

    protected $appends = ['banner'];

    public function imagens()
    {

        return $this->hasMany(Imagem::class)->orderBy('ordem');

    }


    public function getBannerAttribute()
    {
        return

            Imagem::where('assunto_id', $this->id)->where('banner', 1)->first();

    }
}

