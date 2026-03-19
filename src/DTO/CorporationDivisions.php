<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Interfaces\FromArray;

readonly class CorporationDivisions implements FromArray
{
    /**
     * @param  CorporationDivision[]  $hangar
     * @param  CorporationDivision[]  $wallet
     */
    public function __construct(
        public array $hangar,
        public array $wallet,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            hangar: array_map(CorporationDivision::fromArray(...), $data['hangar'] ?? []),
            wallet: array_map(CorporationDivision::fromArray(...), $data['wallet'] ?? []),
        );
    }
}
