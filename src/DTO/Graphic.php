<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class Graphic extends Dto
{
    public function __construct(
        public int $graphic_id,
        public ?string $collision_file,
        public ?string $graphic_file,
        public ?string $icon_folder,
        public ?string $sof_dna,
        public ?string $sof_fation_name,
        public ?string $sof_hull_name,
        public ?string $sof_race_name,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            graphic_id: $data->integer('graphic_id', 0),
            collision_file: $data->string('collision_file'),
            graphic_file: $data->string('graphic_file'),
            icon_folder: $data->string('icon_folder'),
            sof_dna: $data->string('sof_dna'),
            sof_fation_name: $data->string('sof_fation_name'),
            sof_hull_name: $data->string('sof_hull_name'),
            sof_race_name: $data->string('sof_race_name'),
        );
    }
}
