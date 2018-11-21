<?php 

namespace App\Contracts;

interface IdGeneratorInterface
{
    public function generate():string;
}
