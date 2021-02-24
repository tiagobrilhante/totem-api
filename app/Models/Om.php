<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Om extends Model
{

    protected $fillable =['nome','sigla','cor'];
    protected $perPage = 10;


    public function users()
    {
        return $this->hasMany( User::class);

    }

}
