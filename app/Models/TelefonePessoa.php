<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelefonePessoa extends Model
{
    protected $table = 'telefonepessoa';
    protected $fillable = ['idPessoa', 'numeroTelefone', 'operadoraTelefone'];
    protected $primaryKey = 'idTelefone';
    protected $foreignKey = 'idPessoa';
    public $timestamps = false;
    public $incrementing = true;


    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'idPessoa');
    }
    use HasFactory;
}
