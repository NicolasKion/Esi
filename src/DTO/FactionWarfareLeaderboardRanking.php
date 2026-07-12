<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class FactionWarfareLeaderboardRanking extends Dto
{
    /**
     * @param  array<int, FactionWarfareLeaderboardEntry>  $active_total
     * @param  array<int, FactionWarfareLeaderboardEntry>  $last_week
     * @param  array<int, FactionWarfareLeaderboardEntry>  $yesterday
     */
    public function __construct(
        public array $active_total,
        public array $last_week,
        public array $yesterday,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            active_total: $data->list('active_total', FactionWarfareLeaderboardEntry::fromData(...)),
            last_week: $data->list('last_week', FactionWarfareLeaderboardEntry::fromData(...)),
            yesterday: $data->list('yesterday', FactionWarfareLeaderboardEntry::fromData(...)),
        );
    }
}
