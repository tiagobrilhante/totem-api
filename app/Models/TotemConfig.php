<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class TotemConfig extends Model
{
    use SoftDeletes;

    protected $fillable = ['nome_totem','nome_totem_en','nome_totem_es','selected_lang', 'altura_index', 'largura_index', 'altura_detail', 'largura_detail','tipo_totem', 'access_code', 'bg_img', 'bg_color'];

}

