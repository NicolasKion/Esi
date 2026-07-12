<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class FactionWarfareCharacterLeaderboard extends Dto
{
    public function __construct(
        public FactionWarfareCharacterLeaderboardRanking $kills,
        public FactionWarfareCharacterLeaderboardRanking $victory_points,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            kills: FactionWarfareCharacterLeaderboardRanking::fromData($data->object('kills')),
            victory_points: FactionWarfareCharacterLeaderboardRanking::fromData($data->object('victory_points')),
        );
    }
}
