<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class FactionWarfareCharacterLeaderboardRanking extends Dto
{
    /**
     * @param  array<int, FactionWarfareCharacterLeaderboardEntry>  $active_total
     * @param  array<int, FactionWarfareCharacterLeaderboardEntry>  $last_week
     * @param  array<int, FactionWarfareCharacterLeaderboardEntry>  $yesterday
     */
    public function __construct(
        public array $active_total,
        public array $last_week,
        public array $yesterday,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            active_total: $data->list('active_total', FactionWarfareCharacterLeaderboardEntry::fromData(...)),
            last_week: $data->list('last_week', FactionWarfareCharacterLeaderboardEntry::fromData(...)),
            yesterday: $data->list('yesterday', FactionWarfareCharacterLeaderboardEntry::fromData(...)),
        );
    }
}
