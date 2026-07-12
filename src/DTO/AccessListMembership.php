<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * The membership of an {@see AccessList}, only present on the detail
 * endpoint.
 */
readonly class AccessListMembership extends Dto
{
    /**
     * @param  array<int, AccessListAllianceEntry>  $alliances
     * @param  array<int, AccessListCorporationEntry>  $corporations
     * @param  array<int, AccessListCharacterEntry>  $characters
     */
    public function __construct(
        public ?bool $allow_everyone,
        public array $alliances,
        public array $corporations,
        public array $characters,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            allow_everyone: $data->boolean('allow_everyone'),
            alliances: $data->list('alliances', AccessListAllianceEntry::fromData(...)),
            corporations: $data->list('corporations', AccessListCorporationEntry::fromData(...)),
            characters: $data->list('characters', AccessListCharacterEntry::fromData(...)),
        );
    }
}
