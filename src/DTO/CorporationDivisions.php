<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class CorporationDivisions extends Dto
{
    /**
     * @param  array<int, CorporationDivision>  $hangar
     * @param  array<int, CorporationDivision>  $wallet
     */
    public function __construct(
        public array $hangar,
        public array $wallet,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            hangar: $data->list('hangar', CorporationDivision::fromData(...)),
            wallet: $data->list('wallet', CorporationDivision::fromData(...)),
        );
    }
}
