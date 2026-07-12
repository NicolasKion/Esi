<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class AgentResearch extends Dto
{
    public function __construct(
        public int $agent_id,
        public float $points_per_day,
        public float $remainder_points,
        public int $skill_type_id,
        public string $started_at,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            agent_id: $data->integer('agent_id', 0),
            points_per_day: $data->float('points_per_day', 0.0),
            remainder_points: $data->float('remainder_points', 0.0),
            skill_type_id: $data->integer('skill_type_id', 0),
            started_at: $data->string('started_at', ''),
        );
    }
}
