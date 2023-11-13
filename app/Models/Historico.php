<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Historico extends Model
{
    use SoftDeletes;

    protected $fillable = ['evento', 'responsavel', 'user_id'];

    protected $perPage = 50;


    public function user()
    {

        return $this->belongsTo(User::class);

    }


}

