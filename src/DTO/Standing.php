<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class Standing extends Dto
{
    public function __construct(
        public int $from_id,
        public string $from_type,
        public float $standing,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            from_id: $data->integer('from_id', 0),
            from_type: $data->string('from_type', ''),
            standing: $data->float('standing', 0.0),
        );
    }
}
