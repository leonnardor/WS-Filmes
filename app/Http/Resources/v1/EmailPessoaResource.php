<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;


class EmailPessoaResource extends JsonResource
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
            'id' => $this->idEmail,
            'email' => $this->email,
           
            // return name of the person and relationship with the email
            'Usuario' => $this->pessoa->nomePessoa,
        ];
    }
}
