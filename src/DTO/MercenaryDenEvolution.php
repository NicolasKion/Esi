<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class MercenaryDenEvolution extends Dto
{
    public function __construct(
        public MercenaryDenEvolutionLevel $anarchy,
        public MercenaryDenEvolutionLevel $development,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            anarchy: MercenaryDenEvolutionLevel::fromData($data->object('anarchy')),
            development: MercenaryDenEvolutionLevel::fromData($data->object('development')),
        );
    }
}
