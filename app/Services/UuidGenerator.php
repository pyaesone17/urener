<?php 

namespace App\Services;

use App\Contracts\IdGeneratorInterface;
use Uuid;

class UuidGenerator implements IdGeneratorInterface
{
    public function generate() : string
    {
        return Uuid::generate()->string;
    }
}
