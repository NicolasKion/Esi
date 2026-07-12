<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class FactionWarfareLeaderboard extends Dto
{
    public function __construct(
        public FactionWarfareLeaderboardRanking $kills,
        public FactionWarfareLeaderboardRanking $victory_points,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            kills: FactionWarfareLeaderboardRanking::fromData($data->object('kills')),
            victory_points: FactionWarfareLeaderboardRanking::fromData($data->object('victory_points')),
        );
    }
}
