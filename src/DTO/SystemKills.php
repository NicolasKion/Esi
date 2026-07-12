<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class SystemKills extends Dto
{
    public function __construct(
        public int $system_id,
        public int $ship_kills,
        public int $npc_kills,
        public int $pod_kills,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            system_id: $data->integer('system_id', 0),
            ship_kills: $data->integer('ship_kills', 0),
            npc_kills: $data->integer('npc_kills', 0),
            pod_kills: $data->integer('pod_kills', 0),
        );
    }
}
