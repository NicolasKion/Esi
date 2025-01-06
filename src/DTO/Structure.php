<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Interfaces\FromArray;

readonly class Structure implements FromArray
{
    public function __construct(
        public string $name,
        public int $owner_id,
        public Position $position,
        public int $solar_system_id,
        public int $type_id) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            owner_id: $data['owner_id'],
            position: new Position(
                x: $data['position']['x'],
                y: $data['position']['y'],
                z: $data['position']['z'],
            ),
            solar_system_id: $data['solar_system_id'],
            type_id: $data['type_id'],
        );
    }
}
