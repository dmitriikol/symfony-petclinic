<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

trait CollectionToArrayConvertor
{
    private function toArrayProperty($value): array
    {
        return is_array($value) ? $value : $value->toArray();
    }
}
