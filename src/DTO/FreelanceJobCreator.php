<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * The character and corporation that created a {@see FreelanceJob}.
 */
readonly class FreelanceJobCreator extends Dto
{
    public function __construct(
        public FreelanceJobCreatorCharacter $character,
        public FreelanceJobCreatorCorporation $corporation,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            character: FreelanceJobCreatorCharacter::fromData($data->object('character')),
            corporation: FreelanceJobCreatorCorporation::fromData($data->object('corporation')),
        );
    }
}
