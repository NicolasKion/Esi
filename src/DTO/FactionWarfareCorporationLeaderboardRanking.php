<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class FactionWarfareCorporationLeaderboardRanking extends Dto
{
    /**
     * @param  array<int, FactionWarfareCorporationLeaderboardEntry>  $active_total
     * @param  array<int, FactionWarfareCorporationLeaderboardEntry>  $last_week
     * @param  array<int, FactionWarfareCorporationLeaderboardEntry>  $yesterday
     */
    public function __construct(
        public array $active_total,
        public array $last_week,
        public array $yesterday,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            active_total: $data->list('active_total', FactionWarfareCorporationLeaderboardEntry::fromData(...)),
            last_week: $data->list('last_week', FactionWarfareCorporationLeaderboardEntry::fromData(...)),
            yesterday: $data->list('yesterday', FactionWarfareCorporationLeaderboardEntry::fromData(...)),
        );
    }
}
