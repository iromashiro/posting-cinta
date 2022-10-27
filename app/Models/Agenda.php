<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'agendas';
    protected $fillable = ['nama_agenda', 'tanggal'];
}
