<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class CharacterSkills extends Dto
{
    /**
     * @param  array<int, Skill>  $skills
     */
    public function __construct(
        public array $skills,
        public int $total_sp,
        public ?int $unallocated_sp,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            skills: $data->list('skills', Skill::fromData(...)),
            total_sp: $data->integer('total_sp', 0),
            unallocated_sp: $data->integer('unallocated_sp'),
        );
    }
}
