<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guiche extends Model
{

    protected $fillable = ['ip', 'localizacao', 'nome_ref', 'cor', 'panel_id'];
    protected $perPage = 10;


    public function panel()
    {
        return $this->belongsTo(Panel::class);
    }

}
