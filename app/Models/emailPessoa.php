<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\TelefonePessoa;
use App\Models\Pessoa;


class emailPessoa extends Model
{

    
    protected $table = 'emailpessoa';
    protected $primaryKey = 'idEmail';
    protected $fillable = ['email', 'idPessoa'];
    protected $foreignKey = ['idPessoa'];
    public $timestamps = false;
    public $incrementing = true;

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'idPessoa');
    }

    public function telefone()
    {
        return $this->hasMany(TelefonePessoa::class, 'idPessoa');
    }

    use HasFactory;
}
