<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Interfaces\FromArray;

readonly class DogmaItemEffect implements FromArray
{
    public function __construct(public int $effect_id, public bool $is_default)
    {
        //
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['effect_id'],
            $data['is_default']
        );
    }

}
