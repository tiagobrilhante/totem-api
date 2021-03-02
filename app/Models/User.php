<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    protected $table = 'users';
    protected $appends = ['om','guerra'];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cpf',
        'nome',
        'nome_guerra',
        'posto_grad',
        'om_id',
        'tipo'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];


    public function getOmAttribute()
    {
        return

           Om::where('id', $this->om_id)->first();

    }

    public function getGuerraAttribute()
    {
        $user_posto_grad = $this->posto_grad;
        $user_nome_guerra = $this->nome_guerra;
        return

            $user_posto_grad.' '.$user_nome_guerra;

    }




}
