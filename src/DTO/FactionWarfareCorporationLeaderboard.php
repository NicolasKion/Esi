<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class FactionWarfareCorporationLeaderboard extends Dto
{
    public function __construct(
        public FactionWarfareCorporationLeaderboardRanking $kills,
        public FactionWarfareCorporationLeaderboardRanking $victory_points,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            kills: FactionWarfareCorporationLeaderboardRanking::fromData($data->object('kills')),
            victory_points: FactionWarfareCorporationLeaderboardRanking::fromData($data->object('victory_points')),
        );
    }
}
