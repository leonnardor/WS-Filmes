<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class TelefonePessoaResource extends JsonResource
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
            'idTelefone' => $this->idTelefone,
            'numeroTelefone' => $this->numeroTelefone,
            'operadoraTelefone' => $this->operadoraTelefone,
            'pessoa' => new PessoaResource($this->pessoa),
        ];

      
    }
    
}
