<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    protected $table = 'pessoa';
    protected $fillable = ['nomePessoa', 'dataNascimento', 'cpf', 'rg'];
    protected $primaryKey = 'idPessoa';
    public $timestamps = false;
    public $incrementing = true;


    public function telefone()
    {
        return $this->hasMany(TelefonePessoa::class, 'idPessoa');
    }
    
    use HasFactory;
}
