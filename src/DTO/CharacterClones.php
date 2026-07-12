<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class CharacterClones extends Dto
{
    /**
     * @param  array<int, JumpClone>  $jump_clones
     */
    public function __construct(
        public CloneHomeLocation $home_location,
        public array $jump_clones,
        public ?string $last_clone_jump_date,
        public ?string $last_station_change_date,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            home_location: CloneHomeLocation::fromData($data->object('home_location')),
            jump_clones: $data->list('jump_clones', JumpClone::fromData(...)),
            last_clone_jump_date: $data->string('last_clone_jump_date'),
            last_station_change_date: $data->string('last_station_change_date'),
        );
    }
}
