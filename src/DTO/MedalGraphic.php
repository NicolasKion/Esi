<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class MedalGraphic extends Dto
{
    public function __construct(
        public ?int $color,
        public string $graphic,
        public int $layer,
        public int $part,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            color: $data->integer('color'),
            graphic: $data->string('graphic', ''),
            layer: $data->integer('layer', 0),
            part: $data->integer('part', 0),
        );
    }
}
