<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class DogmaItemEffect extends Dto
{
    public function __construct(public int $effect_id, public bool $is_default)
    {
        //
    }

    public static function fromData(Data $data): self
    {
        return new self(
            effect_id: $data->integer('effect_id', 0),
            is_default: $data->boolean('is_default', false),
        );
    }
}
