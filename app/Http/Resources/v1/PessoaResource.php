<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class PessoaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'idPessoa' => $this->idPessoa,
            'nomePessoa' => $this->nomePessoa,
            'dataNascimento' => $this->dataNascimento,
            'cpf' => $this->cpf,
            'rg' => $this->rg,
        ];
        
    }
}
