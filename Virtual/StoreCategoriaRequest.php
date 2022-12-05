<?php 

namespace App\Virtual;

/**
 * @OA\Schema(
 *  schema="Pessoa",
 * title="Pessoa",
 * description="Pessoa",
 * @OA\Xml(
 * name="Pessoa"
 * ),
 * )
 */

class Pessoa{
    /**
     * @OA\Property(
     * title="id",
     * description="id",
     * format="int64",
     * example=1
     * )
     * @var integer
     *          
     * */
    private $id;

    /**
     * @OA\Property(
     * title="nome",
     * description="nome",
     * format="string",
     * example="João"
     * )
     * @var string
     *          
     * */

    private $nome;

}