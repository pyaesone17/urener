<?php 

namespace App\Services;

use App\Contracts\IdGeneratorInterface;

class ShortIdGenerator implements IdGeneratorInterface
{
    public function generate() : string
    {
        return base_convert(random_int(100000, 10000000), 10, 36);
    }
}
